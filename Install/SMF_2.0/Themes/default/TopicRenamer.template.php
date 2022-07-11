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

    echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<span class="ie6_header floatleft"><img alt="rename" src="', $settings['images_url'], '/edit.gif" alt="" class="icon" />', $txt['rename_topic'], '</span>
			</h3>
		</div>
		<span class="upperframe"><span></span></span>
		<div class="roundframe centertext" style="padding: 5ex 10ex; text-align: left;">		
			<form action="', $scripturl, '?action=renameTopic;topic=', $context['current_topic'], '" method="post" accept-charset="', $context['character_set'], '" onsubmit="submitonce(this);">
				<strong>', $txt['rename_topic_subject'], '</strong>:
				<input type="text" name="subject" id="subject" value="', $context['currentSubject'], '" style="width: 70%;"/>
				<input type="submit" value=" ', $txt['rename_topic'], ' " name="renameTopic2" onclick="return submitThisOnce(this);" accesskey="s" style="float: right;" class="button_submit" />				
				<input type="hidden" name="sc" value="', $context['session_id'], '" />
				<input type="hidden" name="TOPIC_ID" value="', $context['current_topic'], '" />
			</form>
		</div>
		<span class="lowerframe"><span></span></span>';
}
