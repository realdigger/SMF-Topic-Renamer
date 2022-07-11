<?php

/**
 * Project: SMF Topic Renamer
 * Version: 3.0
 * File: TopicRenamer.template.php
 * Author: digger @ https://mysmf.net
 * Author: dD#S aka BIOHAZARD @ http://simplemachines.org/community/index.php?action=profile;u=189535
 * License: The MIT License (MIT)
 */

/**
 * Template for rename form
 *
 * @return void
 */
function template_main()
{
    global $context, $settings, $txt, $scripturl;

    loadLanguage('TopicRenamer/TopicRenamer');

    ?>

    <div class="cat_bar">
        <h3 class="catbg">
            <?= $txt['rename_topic'] ?>
        </h3>
    </div>
    <span class="upperframe"><span></span></span>
    <div class="roundframe noup centertext">
        <form action="<?= $scripturl ?>?action=renameTopic;topic=<?= $context['current_topic'] ?>" method="post"
              accept-charset="<?= $context['character_set'] ?>" onsubmit="submitonce(this);">

		<span class="post_button_container">
            <label for="subject"><strong class=""><?= $txt['rename_topic_subject'] ?></strong>: </label><input
                    type="text" name="subject" id="subject" value="<?= $context['currentSubject'] ?>" size="80"
                    maxlength="80" tabindex="1"/>
            <input type="hidden" name="sc" value="<?= $context['session_id'] ?>"/>
            <input type="hidden" name="TOPIC_ID" value="<?= $context['current_topic'] ?>"/>
            <input type="submit" value="<?= $txt['rename_topic'] ?>" name="renameTopic2"
                   onclick="return submitThisOnce(this);"
                   accesskey="s" class="button" tabindex="2">
		</span>

        </form>
    </div>
    <span class="lowerframe"><span></span></span>

    <?php
}