<?php
$PageName="Language";
$FormRequired=1;
$TableRequired=1;
$TooltipRequired=1;
$SearchRequired=1;
include("Include.php");
IsLoggedIn();
include("Template/HTML.php");
?>
<?php
include("Template/Header.php");
?>

<?php
include("Template/Sidebar.php");
?>
<?php  
if(isset($_POST['Language']))
{
	
	
	

	$query1="select TranslateId from translate where LanguageId='$LANGUAGE' ";
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt12 = sqlsrv_query( $conn, $query1 , $params, $options );
	$count1 = sqlsrv_num_rows($stmt12);
    $PhraseTranslate=$Message=$Type = "";
		if($PhraseIdArray!="")
		foreach($PhraseIdArray as $PhraseIdArrayValue)
		{
			 $Field="T_$PhraseIdArrayValue";
			if(isset($_POST[$Field])){
				$PhraseTranslate=$_POST[$Field];
			}
			
			$Translation[]="$PhraseIdArrayValue**$PhraseTranslate";
		}
		
		$Translation=implode("||",$Translation);
		if($count1>0){
		$TQuery = "update translate set Translation='$Translation' where LanguageId='$LANGUAGE'";	
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt01 = sqlsrv_query( $conn, $TQuery , $params, $options );
		}else{
		$TSQuery = "insert into translate (Translation,LanguageId) values ('$Translation','$LANGUAGE')";
		
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt01 = sqlsrv_query( $conn, $TSQuery , $params, $options );
		$Message="Saved successfully!!";
		$Type="success";
		}
	
	SetNotification($Message,$Type);
	//header("Location:Language");
}
?>
        <div id="content" class="clearfix">
            <div class="contentwrapper">
                <?php $BreadCumb="Language"; BreadCumb($BreadCumb); ?>
				<?php DisplayNotification(); 
				$Action=isset($_GET['Action']) ? $_GET['Action'] : '';
				$Id=isset($_GET['Id']) ? $_GET['Id'] : '';
				$query="select LanguageName,LanguageId from lang";
				$DATA=array();
				$QA=array();
				$LanguageAction=$SelectedLanguageName=$PhraseAction=$SelectedPhrase="";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $query , $params, $options );
				$count = sqlsrv_num_rows($stmt);
				while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
					$ListLanguageName=$row['LanguageName'];	
					$ListLanguageId=$row['LanguageId'];	
					if($Action=="UpdateLanguage" && $Id==$ListLanguageId)
					{
						$SelectedLanguageName=$ListLanguageName;
						$SelectedLanguageId=$ListLanguageId;
						$LanguageAction="Update";
					}
					$Edit="<a href=Language/UpdateLanguage/$ListLanguageId><span class=\"icon-edit tip\" title=\"Update\"></span></a>";
					$Delete="<a href=Language/DeleteLanguage/$ListLanguageId data-toggle=\"modal\" data-target=\"#myModal\"><span class=\"icomoon-icon-cancel\"></span></a>";
					$Option="$Edit $Delete";
					$QA[]=array($ListLanguageName,$Option);
				}
				$DATA['aaData']=$QA;
				$fp = fopen('plugins/Data/data1.txt', 'w');
				fwrite($fp, json_encode($DATA));
				fclose($fp);
				
				$query1="select Phrase,PhraseId from phrase";
				$DATA1=array();
				$QA1=array();
				
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt12 = sqlsrv_query( $conn, $query1 , $params, $options );
				$count = sqlsrv_num_rows($stmt12);
				$i=0;
				$TranslateForm="";
				while($row1=sqlsrv_fetch_array($stmt12, SQLSRV_FETCH_ASSOC))
				{
					$i++;
					$ListPhrase=$row1['Phrase'];	
					$ListPhraseId=$row1['PhraseId'];	
					if($Action=="UpdatePhrase" && $Id==$ListPhraseId)
					{
						$SelectedPhrase=$ListPhrase;
						$SelectedPhraseId=$ListPhraseId;
						$PhraseAction="Update";						
					}

					$PhraseTranslate=Translate($ListPhraseId);
					if($i%4==1)
					$TranslateForm.="<div class=\"form-row row-fluid\">";
					$TranslateForm.="<div class=\"span3\">
											<div class=\"row-fluid\">
											<label class=\"form-label span4\" for=\"LanguageName\"><b>$ListPhrase</b></label>
											<input autocomplete=\"off\" tabindex=\"1\" class=\"span8 tip\" type=\"text\" name=\"T_$ListPhraseId\" value=\"$PhraseTranslate\" />	
											</div>
										</div>"; 
					if($i%4==0)					
					$TranslateForm.="</div>";
					$Edit1="<a href=Language/UpdatePhrase/$ListPhraseId><span class=\"icon-edit tip\" title=\"Update\"></span></a>";
					$Delete1="<a href=Language/DeletePhrase/$ListPhraseId data-toggle=\"modal\" data-target=\"#myModal\"><span class=\"icomoon-icon-cancel\"></span></a>";
					$Option1="$Edit1 $Delete1";
					$QA1[]=array($ListPhrase,$Option1);
				}
				$DATA1['aaData']=$QA1;
				$fp = fopen('plugins/Data/data2.txt', 'w');
				fwrite($fp, json_encode($DATA1));
				fclose($fp);
				?>							
				<?php if($LANGUAGE!=0) { ?>
                <div class="row-fluid">
                    <div class="span12">
						<form class="form-horizontal" action="Action" name="Translation" id="Translation" method="Post">
                        <div class="box chart gradient">
                            <div class="title">
                                <h4>
                                    <span>Add "<?php echo $SelectedLang; ?>" translation</span><button type="submit" class="btn btn-info btn-mini" style="margin-left:20px;"><?php echo Translate('Save'); ?></button>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content scroll" style="max-height:300px; overflow:auto;  padding-bottom:0;">
								<?php echo $TranslateForm; ?>
							</div>
							<input type="hidden" name="Action" value="Translation" readonly>
							<input type="hidden" name="Language" value="" readonly>
							<input type="hidden" name="RandomToken" value="<?php echo $TOKEN; ?>" readonly>
						</div>
						</form>
					</div>
				</div>
				<?php } ?>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="box chart gradient">
                            <div class="title">
                                <h4>
                                    <span><?php echo "$LanguageAction"; ?> Language</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content noPad clearfix" style="padding-bottom:0;">
								<form class="form-horizontal" action="Action" name="Language" id="Language" method="Post">
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
											<label class="form-label span4" for="LanguageName">Language Name</label>
											<input tabindex="1" class="span8 tip" title="Mandatory : Language Name" id="LanguageName" type="text" name="LanguageName" value="<?php echo $SelectedLanguageName; ?>" />	
											</div>
										</div> 
									</div>
										<input type="hidden" name="Action" value="Language" readonly>
										<?php if($LanguageAction=="Update") { ?>
										<input type="hidden" name="LanguageId" value="<?php echo $Id; ?>" readonly>
										<?php } ?>
										<input type="hidden" name="RandomToken" value="<?php echo $TOKEN; ?>" readonly>
									<?php ActionButton('Save',2); ?>
								</form>
								
								<table id="LanguageTable" cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
									<thead>
										<tr>
											<th>Language</th>
											<th><span class="icon-edit tip" title="Update"></span> 
											<span class="icomoon-icon-cancel tip" title="Delete"></span></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
                            </div>
                        </div>
					</div>
					<div class="span6">
                        <div class="box chart gradient">
                            <div class="title">
                                <h4>
                                    <span><?php echo "$PhraseAction"; ?> <?php echo Translate('Phrase'); ?> </span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content noPad clearfix" style="padding-bottom:0;">
								<form class="form-horizontal" action="Action" name="Phrase" id="Phrase" method="Post">
									<div class="form-row row-fluid">
										<div class="span12">
											<div class="row-fluid">
											<label class="form-label span4" for="Phrase">Phrase</label>
											<input tabindex="3" class="span8 tip" title="Mandatory : Phrase" id="Phrase" type="text" name="Phrase" value="<?php echo $SelectedPhrase; ?>" />	
											</div>
										</div> 
									</div>
										<input type="hidden" name="Action" value="Phrase" readonly>
										<?php if($PhraseAction=="Update") { ?>
										<input type="hidden" name="PhraseId" value="<?php echo $Id; ?>" readonly>
										<?php } ?>
										<input type="hidden" name="RandomToken" value="<?php echo $TOKEN; ?>" readonly>
									<?php ActionButton('Save',4); ?>
								</form>
								
								<table id="PhraseTable" cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
									<thead>
										<tr>
											<th>Phrase</th>
											<th><span class="icon-edit tip" title="Update"></span> 
											<span class="icomoon-icon-cancel tip" title="Delete"></span></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>		
                </div>
            </div>
        </div>

<script type="text/javascript">
$(document).ready(function() {

$('#LanguageTable').dataTable({
	"aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
	"sPaginationType": "two_button",
	"bJQueryUI": false,
	"bAutoWidth": false,
	"bLengthChange": false,  
	"bProcessing": true,
	"bDeferRender": true,
	"bStateSave": true,
	"sAjaxSource": "plugins/Data/data1.txt",
	"fnInitComplete": function(oSettings, json) {
	  $('.dataTables_filter>label>input').attr('id', 'search');
			$('#LanguageTable').on('click', 'a[data-toggle=modal]', function(e) {
			lv_target = $(this).attr('data-target');
			lv_url = $(this).attr('href');
			$(lv_target).load(lv_url);
			});	
	}
});
$('#PhraseTable').dataTable({
	"aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
	"sPaginationType": "two_button",
	"bJQueryUI": false,
	"bAutoWidth": false,
	"bLengthChange": false,  
	"bProcessing": true,
	"bDeferRender": true,
	"bStateSave": true,
	"sAjaxSource": "plugins/Data/data2.txt",
	"fnInitComplete": function(oSettings, json) {
	  $('.dataTables_filter>label>input').attr('id', 'search');
			$('#PhraseTable').on('click', 'a[data-toggle=modal]', function(e) {
			lv_target = $(this).attr('data-target');
			lv_url = $(this).attr('href');
			$(lv_target).load(lv_url);
			});	
	}
});
	$("input, textarea, select").not('.nostyle').uniform();
	$("#Language").validate({
		ignore: 'input[type="hidden"]',
		rules: {
			LanguageName: {
				required: true,
			}
		} 
	});
	$("#Phrase").validate({
		rules: {
			Phrase: {
				required: true,
			}
		}  
	});
});
</script>
		
<?php
include("Template/Footer.php");
?>