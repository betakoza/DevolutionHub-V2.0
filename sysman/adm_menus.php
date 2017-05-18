<?php include("sec__head.php"); ?>

<!-- @begin :: content area -->
<div>



<?php

if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }

$image_show = '';
$article = '';
$static = '';
$quicklink = '';
$title_seo = '';

if($op=="edit"){

	if($id){
	
	$sqdata="SELECT       `id`, `title`, `title_alias`, `id_section`, `id_type_menu`, `parent`, `description`, `link`, `target`, `published`, `image`, `id_access`, `id_parent2`, `seq`, `static`, `metawords`, `title_brief`, `parent`, `quicklink`, `image_show`,`id_portal`, `title_seo`   FROM       `".$pdb_prefix."dt_menu`  WHERE  (`id` = ".quote_smart($id).")";
	//echo $sqdata;
	
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata = $cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Edit Menu Details</h2>";
		
		$id					= $cndata[0];
		$title				= html_entity_decode(stripslashes($cndata[1]));
		$title_alias		= html_entity_decode(stripslashes($cndata[2]));
		$id_section			= $cndata[3]; 
		$id_type_menu		= $cndata[4];
		$id_parent1			= $cndata[5];
		$description		= html_entity_decode(stripslashes($cndata[6])); 
		
		$article			= html_entity_decode(stripslashes($cndata[6])); 
		$article	= str_replace(SITE_PATH, '', $article);
		$article	= str_replace(SITE_DOMAIN_LIVE, '', $article);		
		$article 	= str_replace('"image/', '"'.SITE_DOMAIN_LIVE.'image/', $article);
		$article	= remove_special_chars(stripslashes($article));
		
		$link				= $cndata[7];
		$target				= $cndata[8];
		$published			= $cndata[9];
		$image				= $cndata[10];
		$id_access			= $cndata[11];
		$image_show			= $cndata[19];
		$id_portal			= $cndata[20];
		//$metawords			= html_entity_decode(stripslashes($cndata[15]));
		$metawords			= $cndata['metawords'];
		$title_seo			 = $cndata['title_seo'];
		
		$title_brief		= html_entity_decode(stripslashes($cndata[16]));
		$parent				= unserialize($cndata[17]); 
		
		
		/*$sq_menu_parent="SELECT       `id`, `title`, `title_alias`, `id_section`, `id_type_menu`, `parent`, `description`, `link`, `target`, `published`, `image`, `id_access`, `id_parent2`, `seq`, `static`, `metawords`, `title_brief`, `parent`, `quicklink`, `image_show`,`id_portal`   FROM       `".$pdb_prefix."dt_menu`  WHERE  (`id` = ".quote_smart($id).")";*/
		
		//displayArray($parent);
		
		
		
		if($image <> '') { $image_disp = "<br /><br /><img src=\"".DISP_GALLERY.$image."\" style=\"height:100px\">"; }// 
			
			
		$position			  = $cndata[13];
		$static				= $cndata[14];
		$quicklink				= $cndata[18];
				
		if($published==1) {$published="checked ";} else {$published="";}
		if($static==1) {$static="checked ";} else {$static="";}
		if($quicklink==1) {$quicklink="checked ";} else {$quicklink="";}
		
		
		if($image_show==1) {
			$image_show	=" checked ";
		} else {
			$image_show	="";
		}
		
		$formname			= "menu_edit";
		}
	}
} elseif($op=="new")
	{
	
		$pgtitle				="<h2 style=\"padding:0; margin:0;\">Add New Menu</h2>";
		
		$id					= "";
		$title				= "";
		$title_alias		= "";
		$id_section			= 1;
		$id_type_menu		= 2;
		$id_parent1			= "";
		$description		= "";
		$link				= "";
		$target				= "";
		$published			="checked ";
		$image				="";
		$id_access			=1;
		
		$id_parent2			= "";
		$metawords			= "";
		
		$image				="";
		$image_disp			= "";
		$upload_pic			= " ";
		$upload_picn			= " ";
		
		$position				= "9";
		
		$formname			= "menu_new";
	}
$access_y = $access_n = "";
if($id_access==1) {$access_y="checked ";} else {$access_n="checked";}	
?>

  <div style="width:990px; margin:0 auto">
	<form class="admform" name="rage" method="post" action="adm_posts.php" enctype="multipart/form-data" onSubmit="javascript:return valid_menu()">
    <?php echo $pgtitle; ?>
	  <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" class="tims">
         
        <tr>
          <td><label>Title</label></td>
          <td colspan="4"><input type="text" name="title" id="menu_title" value="<?php echo $title; ?>" class="text_full" maxlength="100"/></td>
          
        </tr>
		<tr>
          <td><label>Title Alias </label></td>
          <td colspan="4"><input type="text" name="title_alias"  value="<?php echo $title_alias; ?>" class="text_full" maxlength="100" /></td>
        </tr>
		
		<tr>
          <td><label>Menu Reference </label></td>
          <td colspan="4"><input type="text" name="title_seo" id="title_seo"  value="<?php echo $title_seo; ?>" class="text_full" maxlength="100" /></td>
        </tr>
		
        <tr>
		  <td><label>Menu Type </label></td>
          <td><select name="id_type_menu">
           <?php echo $ddSelect->dropper_select("".$pdb_prefix."dd_menu_type", "id", "title", $id_type_menu) ?>
		   </select>          </td>
          <td>&nbsp;</td>
          <td><label>Section</label></td>
          <td><select name="id_section">
            <?php echo $ddSelect->dropperSection($id_section); ?>
          </select></td>
        </tr>
        
        
        <tr>
          <td nowrap="nowrap"><label> Menu Parent</label></td>
          <td><select name="id_parent1[]" id="id_parent" multiple="multiple" class="multiple">
            <?php echo $dispData->build_MenuSelectRage($id, $parent); ?>
			<?php //echo $dispData->build_MenuSelect($dispData->menuMain_portal, $id_parent1, $id , $parent);  ?>
			
          </select></td>
		  <td>&nbsp;</td>
           <td><label>Manual Link</label></td>
		  <td><input type="text" name="link"  value="<?php echo $link; ?>" maxlength="150" /></td>
          
        </tr>
        <?php /*?>
		 <tr>
          <td nowrap="nowrap"><label> Menu Icon</label></td>
          <td><input type="text" name="title_icon" id="title_icon" value="<?php echo $options['title_icon']; ?>" maxlength="15"/></td>
		  <td>&nbsp;</td>
           <td></td>
		  <td></td>
          
        </tr>
		
        
		<tr>
		  <td nowrap="nowrap"><label>Menu Intro:</label></td>
		  <td colspan="4"><?php
				include("fck_rage/article_sm.php") ;
			  ?></td>
	    </tr><?php */?>
        
        <tr>
          <td><label>Menu Keywords: </label></td>
          <td><input type="text" id="metawords" name="metawords"  value="<?php echo $metawords; ?>" class="text_full" /></td>
		  <td></td>
		  <td><label>Access</label></td>
          <td>
		  <div class="radio_group">
	<label>Public: <input type="radio" name="id_access" value="1" <?php echo $access_y; ?> class="radio"/></label>
	
	&nbsp;&nbsp;&nbsp;&nbsp;
	<label>Private: <input type="radio" name="id_access" value="2" <?php echo $access_n; ?> class="radio"/></label>
          </div>
		  </td>
		 
        </tr>
		<tr>
          <td nowrap="nowrap"><label>Menu Options:</label></td>
          <td colspan="4">
          <div class="radio_group">
	<label>Position: <input type="text" name="position" value="<?php echo $position; ?>" class="radio" maxlength="2"/></label>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<label>Add to Header: <input type="checkbox" name="yn_quicklink" <?php echo $quicklink; ?> class="radio"/></label>
	
	&nbsp;&nbsp;&nbsp;&nbsp;
	<label>Add to Footer: <input type="checkbox" name="yn_static" <?php echo $static; ?> class="radio"/></label>
	
	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><strong>Is Active:</strong> <input type="checkbox" name="published" <?php echo $published; ?> class="radio"/>
<em>(Yes / No)</em></label>
          </div>
          </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td colspan="2">&nbsp;</td>
        	</tr>
			
		<?php if($op=="new") { ?>	
        <tr>
          <td></td>
          <td><label><input type="checkbox" id="add_content" name="add_content" class="radio"/>
Add Menu Content</label></td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
		
		
        <tr id="tr_menu_content" style="display: none">
        	<td nowrap="nowrap"> <label>Menu Content Title</label><br />
				<label>Menu Content</label></td>
        	<td colspan="4">
				<input type="text" name="article_title" id="article_title" class="text_full"><br />
				<?php include("fck_rage/article.php"); ?></td>
        	</tr>
		
		<?php } ?>
		
		
		
        <tr>
          <td>&nbsp;</td>
          <td colspan="4">
		  <input type="hidden" name="id_portal" value="1" />
          <input type="hidden" name="formname" value="<?php echo $formname; ?>" />
          <input type="hidden" name="pagebanner_current" value="<?php echo $image; ?>" />
		  <input type="hidden" name="id" value="<?php echo $id; ?>" />
		  <input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir."&op=list"; ?>" />		  
		  <input type="submit" name="Submit" value="Submit Menu" onClick="javascript: return valid_menu()" id="in_big" style="height:30px;"/></td>
          </tr>
      </table>
	</form>	
	</div>
	
</div>
</div>

<?php include("sec__foot.php"); ?>
	
<script type="text/javascript">
jQuery(document).ready(function($) 
{ 
	$("#add_content").click(function () { 
		if($("#add_content").is(':checked')) {
			$("#tr_menu_content").show();  
			$("#article_title").attr('value', $("input#menu_title").val());  }
		else {
			$("#tr_menu_content").hide(); }
	});	
	
	$("#menu_title").blur(function () {
	  var valTitle 	= $(this).val();
	  var hyphenated  = urlTitle(valTitle);             
	  $('#title_seo').val(hyphenated);       
	  
	  var valKeywords = $("#metawords").val();
	  var valMeta 	  = valTitle.replace(/[^a-zA-Z0-9]/g,",").replace(/[,]+/g,",").toLowerCase();
	  if(valKeywords == "") {  $("#metawords").val(valMeta); }
	});
});


</script>

</body>
</html>
