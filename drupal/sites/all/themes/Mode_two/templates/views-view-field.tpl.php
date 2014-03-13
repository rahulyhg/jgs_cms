<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */


?>

<?php if($view->name=="cwgz_view"): ?>
     <div id="node-<?php print $row->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	      <ul>
             <li>
             <a href="/node/<?php print $row->nid; ?>" title="" target="_blank"><?php print $row->node_title; ?></a>
		  <span>
		  <?php if($face=="笑脸"):?>
		     <img src='sites/all/themes/holiday/images/xiao.jpg' />
		  <?php elseif($face=="哭脸"): ?>
		     <img src='sites/all/themes/holiday/images/ku.jpg' />
		  <?php endif; ?>
		  </span>
             </li>
   	      </ul>
     </div>
<?php elseif ($view->name=="dqtd_view"):?>
    <div id="node-<?php print $row->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	    <ul>
            <li><span class="span_style width_200"> <a href="/node/<?php print $row->nid; ?>"  title="" target="_blank"><?php print $row->node_title; ?></a></span> </li>
   	    </ul>
     </div>
<?php elseif ($view->name=="slide_images_view"):?>
     <div id="node-<?php print $row->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	    <ul>
            <li><span class="span_style width_200"> <a href="/node/<?php print $row->nid; ?>"  title="" target="_blank"><?php print $row->node_title; ?></a></span> </li>
   	    </ul>
     </div>
<?php else :?>
     <div id="node-<?php print $row->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	    <ul>
            <li><span><?php print date('Y-m-d',$row->node_created); ?></span><span class="span_style width_200"> <a href="/node/<?php print $row->nid; ?>"  title="" target="_blank"><?php print $row->node_title; ?></a></span> </li>
   	    </ul>
     </div>
<?php endif;?>
