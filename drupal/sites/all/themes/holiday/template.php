<?php


/**
 * Add body classes if certain regions have content.
 */
function holiday_preprocess_html(&$variables) {
  if (!empty($variables['page']['featured'])) {
    $variables['classes_array'][] = 'featured';
  }

  if (!empty($variables['page']['triptych_first'])
    || !empty($variables['page']['triptych_middle'])
    || !empty($variables['page']['triptych_last'])) {
    $variables['classes_array'][] = 'triptych';
  }

  if (!empty($variables['page']['footer_firstcolumn'])
    || !empty($variables['page']['footer_secondcolumn'])
    || !empty($variables['page']['footer_thirdcolumn'])
    || !empty($variables['page']['footer_fourthcolumn'])) {
    $variables['classes_array'][] = 'footer-columns';
  }

  // Add conditional stylesheets for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
}

/**
 * Override or insert variables into the page template for HTML output.
 */
function holiday_process_html(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
  

  if(theme_get_setting("holiday_theme_style")){
  	$variables['holiday_theme_style'] = theme_get_setting("holiday_theme_style");
  }
}

/**
 * Override or insert variables into the page template.
 */
function holiday_process_page(&$variables) {


  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $variables['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $variables['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function holiday_preprocess_maintenance_page(&$variables) {
  // By default, site_name is set to Drupal if no db connection is available
  // or during site installation. Setting site_name to an empty string makes
  // the site and update pages look cleaner.
  // @see template_preprocess_maintenance_page
  if (!$variables['db_is_active']) {
    $variables['site_name'] = '';
  }
  drupal_add_css(drupal_get_path('theme', 'holiday') . '/css/maintenance-page.css');
}

/**
 * Override or insert variables into the maintenance page template.
 */
function holiday_process_maintenance_page(&$variables) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
}

/**
 * Override or insert variables into the node template.
 */
function holiday_preprocess_node(&$variables) {
  global $user;

  if(!$user->uid && ($variables['type'] == 'gsgg' || $variables['type'] == 'qualification' || $variables['type'] == 'ztbxx' || $variables['type'] == 'bszn')){
  	 
   	header('Location: https://www.hkjgzx.sh.cn/login?service=http%3A%2F%2Fwww.hkjgzx.sh.cn%2Fcas%3Fdestination%3Dnode&locale=zh_CN'); 
  }
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Override or insert variables into the block template.
 */
function holiday_preprocess_block(&$variables) {
  // In the header region visually hide block titles.
  if ($variables['block']->region == 'header') {
    $variables['title_attributes_array']['class'][] = 'element-invisible';
  }
}

/**
 * Implements theme_menu_tree().
 */
function holiday_menu_tree($variables) {
  return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_field__field_type().
 */
function holiday_field__taxonomy_term_reference($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
  }

  // Render the items.
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] .'>' . $output . '</div>';

  return $output;
}

/**
 * Implements hook_form_alter().
*/
function holiday_form_alter(&$form, $form_state, $form_id) {
	if($form_id == 'workers_activist_node_form' || $form_id == 'suggestion_node_form') {
		//add function to complete to at the end of array
		//print $form_id;
		$form_state['redirect'] = 'node/submitted_successfully';
	}else{
		$form_state['redirect'] = '';
	}
}


function array_diff_assoc_recursive($array1, $array2) {
	foreach ($array1 as $key => $value) {
		if (is_array($value)) {
			if (!isset($array2[$key]) || !is_array($array2[$key])) {
				$difference[$key] = $value;
			} else {
				$new_diff = array_diff_assoc_recursive($value, $array2[$key]);
				if ($new_diff != FALSE) {
					$difference[$key] = $new_diff;
				}
			}
		} elseif (!isset($array2[$key]) || $array2[$key] != $value) {
			$difference[$key] = $value;
		}
	}
	return !isset($difference) ? 0 : $difference;
}

function getMisUser(){
	global $user;
	if (isset ( $user)) {

		if($user->uid == 0){
			return "匿名用户";
		}
		
		$array = get_object_vars($user);

		$result = checkIsJgsUser($array);
		if($result == ""){		
			return "内部用户";
		}else{
			return $result;
		}
	} else {
		return "匿名用户";
	}
}

function checkIsJgsUser($array){
	$result = "";
	foreach ($array as $key => $value) {
			
		if (is_array($value)) {
			 $result .=   checkIsJgsUser($value);
		}else{
	
			if (strpos ( $value, "USER_TYPE_NAME施工单位" ) > 0) {
				$result .= "施工单位";
			}
			if (strpos ( $value, "USER_TYPE_NAME监理单位" ) > 0) {
	
				$result .= "监理单位";
			}
			if (strpos ( $value, "USER_TYPE_NAME建设单位" ) > 0) {
	
				$result .= "建设单位";
			}
	
			if (strpos ( $value, "anonymous user" ) > 0) {
				$result .= "匿名用户";
			}
	
		}
	}
	
	return $result;
}

function isJgsUser(){
	if(getMisUser() == "内部用户"){
		return true;
	}

	return false;
}