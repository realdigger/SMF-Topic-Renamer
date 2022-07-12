<?php

/**
 * Project: SMF Topic Renamer
 * Version: 3.0
 * File: Mod-TopicRenamer.php
 * Author: digger @ https://mysmf.net
 * Author: dD#S aka BIOHAZARD @ http://simplemachines.org/community/index.php?action=profile;u=189535
 * License: The MIT License (MIT)
 */

if (!defined('SMF')) {
    die ('Hacking attempt...');
}

class TopicRenamer
{

    /**
     * Mod hooks
     * @return void
     */
    public static function loadHooks()
    {
        add_integration_function('integrate_actions', __CLASS__ . '::actions', false);
        add_integration_function('integrate_mod_buttons', __CLASS__ . '::buttons', false);
        add_integration_function('integrate_load_permissions', __CLASS__ . '::permissions', false);
    }


    /**
     * Mod main function
     * @return void
     */
    public static function rename()
    {
        global $txt, $context, $smcFunc, $forum_version;

        loadLanguage('TopicRenamer/TopicRenamer');

        // Check if allowed to renameTopic.
        isAllowedTo(['rename_topic_own', 'rename_topic_any']);

        // Load the template.
        loadTemplate('TopicRenamer');

        // Check if a topic id is set.
        if (!isset($_REQUEST['topic']) || is_array($_REQUEST['topic'])) {
            fatal_lang_error('rename_topic_no_id');
        }

        // Define topic id.
        $id_topic = (int)$_REQUEST['topic'];

        // Select the current subject.
        $result = $smcFunc['db_query'](
            '',
            '
		SELECT m.subject
		FROM ({db_prefix}messages AS m, {db_prefix}topics AS t)
		WHERE m.id_topic = {int:topic}
			AND t.id_first_msg = m.id_msg
		LIMIT 1',
            [
                'topic' => $id_topic,
            ]
        );

        // List the result.
        list ($currentSubject) = $smcFunc['db_fetch_row']($result);
        $smcFunc['db_free_result']($result);

        // Stripslashes and htmlspecialchars
        $tempText                  = $smcFunc['db_unescape_string']($currentSubject);
        $context['currentSubject'] = strtr(censorText($tempText), ["\r" => '', "\n" => '', "\t" => '']);

        // If renameTopic isset do the renaming.
        if (isset($_POST['renameTopic2']) && !empty($_POST['subject'])) {
            // Check if they have a valid session.
            checkSession();

            // Clean the new subject.
            $_POST['subject'] = strtr(
                $smcFunc['htmlspecialchars']($_POST['subject']),
                ["\r" => '', "\n" => '', "\t" => '']
            );

            // At this point, we want to make sure the subject isn't too long (and subject fits in the tinytext of the database - 255).
            if ($smcFunc['strlen']($_POST['subject']) > 100) {
                $_POST['subject'] = $smcFunc['db_escape_string'](
                    $smcFunc['substr']($smcFunc['db_unescape_string']($_POST['subject']), 0, 100)
                );
            }

            // Do the dew.
            $update = $smcFunc['db_query'](
                '',
                '
			UPDATE {db_prefix}messages
			SET subject = {string:subject}
			WHERE id_topic = {int:topic}',
                [
                    'subject' => $_POST['subject'],
                    'topic'   => $id_topic,
                ]
            );

            // Check if it went through.  If so redirect.
            if ($update) {
                redirectexit('topic=' . $id_topic);
            } else {
                redirectexit('action=renameTopic;topic=' . $id_topic);
            }
        }

        // Set the title.
        $context['page_title'] = $txt['rename_topic'] . ' "' . $currentSubject . '"';
    }


    /**
     * Mod permissions
     * @param $permissionGroups
     * @param $permissionList
     * @return void
     */
    public static function permissions(&$permissionGroups, &$permissionList)
    {
        loadLanguage('TopicRenamer/TopicRenamer');

        $permissionList['board'] += [
            'rename_topic' => [true, 'topic', 'moderate', 'moderate'],
        ];
    }


    /**
     * Mod actions
     * @param $actionsArray
     * @return void
     */
    public static function actions(&$actionsArray)
    {
        $actionsArray['renameTopic'] = ['Mod-TopicRenamer.php', 'TopicRenamer::rename'];
    }


    /**
     * Mod buttons
     * @param $mod_buttonsArray
     * @return void
     */
    public static function buttons(&$mod_buttonsArray)
    {
        global $context, $scripturl;

        loadLanguage('TopicRenamer/TopicRenamer');

        $mod_buttonsArray['renameTopic'] = [
            'test'  => 'can_delete',
            'text'  => 'rename_topic',
            'image' => 'edit.gif',
            'lang'  => true,
            'url'   => $scripturl . '?action=renameTopic;topic=' . $context['current_topic'] . ';' . $context['session_var'] . '=' . $context['session_id']
        ];
    }
}