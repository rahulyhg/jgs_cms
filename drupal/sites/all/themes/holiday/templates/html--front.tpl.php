<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script>
jQuery(function($){
    $('.slideBox').slideBox({
        duration : 0.3,//滚动持续时间，单位：秒
        easing : 'linear',//swing,linear//滚动特效
        delay : 7,//滚动延迟时间，单位：秒
        hideClickBar : false,//不自动隐藏点选按键
        clickBarRadius : 10
    });
});
function ass(){
	  if($(document).scrollTop()>=200){
		  <?php global $user;?>
		  <?php if($user ->uid):?>
			  $("#main-menu").addClass("main-menu-fix");
		  <?php else: ?>
		      $("#main-menu").addClass("main-menu-fix2");
		  <?php endif;?>
  	     
      }else{
    	  <?php global $user;?>
		  <?php if($user ->uid):?>
			  $("#main-menu").removeClass("main-menu-fix");
		  <?php else: ?>
		      $("#main-menu").removeClass("main-menu-fix2");
		  <?php endif;?>
      }
}
 setInterval("ass()",10);
</script>
</head>
<?php print_r($variables['holiday_theme_style']);?>

<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>

  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  <script>
     var img_title = $(".img_title");
     var img_href =$(".img_href");
     for(var i=0;i<img_title.length;i++){
    	 $(img_href[i]).find("a").attr("title",$(img_title[i]).find("a").text());
     }
     $(".img_title").hide();
  </script>
</body>
</html>
