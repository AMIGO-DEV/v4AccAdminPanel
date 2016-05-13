<?php
	$PageName="Productmaster";
	$TooltipRequired=1;
	$SearchRequired=1;
	$FormRequired=1;
	$TableRequired=1;
	require_once 'config.php';
	include("Include.php");
	//IsLoggedIn();
	include("Template/HTML.php");

	if( $conn === false)
	{
		die( print_r( sqlsrv_errors(), true));
	}

	
	
	if(isset($_POST['dispatch_order']))
	{
		
		$order_no = $_POST['order_no'];
		
		$orderdate = date("d/m/Y h:i:s A");
		
		
		
		$new = "select top 1 * from StkTrnHdr where TrnType = 9700 and TrnCtrlNo = '$order_no' ORDER BY DocNo DESC";
		$stmt = sqlsrv_query( $conn, $new );
		
			
			while( $row = sqlsrv_fetch_array($stmt) ) {
					
				 $RecordSet = $row['DocNo'];
			
			}
			
			$new2 = "select top 1 * from StkTrnHdr where TrnType = 9700 ORDER BY TrnCtrlNo DESC";
			$stmt2 = sqlsrv_query( $conn, $new2 );
			
			if( $stmt2 === false ) {
				if( ($errors = sqlsrv_errors() ) != null) {
				foreach( $errors as $error ) {
													echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
													echo "code: ".$error[ 'code']."<br />";
													echo "message: ".$error[ 'message']."<br />";
												}
											}
			}	
			
			while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
				   $RecordSet2 = $row2['TrnCtrlNo'];
			}
			$doc = $RecordSet + 1;
			$trncntrl = $RecordSet2 + 1;
			$DocNoPrefix = "L18O".""."16";
			
			
			//echo $DocNoPrefix;
		$qty2 = "";
		
		$client = "";
		$user = $_SESSION['USERNAME'];
		foreach($_POST['Stoke_no'] as $key=>$val) 
		{
			
			$qty = $_POST['dispatch_price'][$key];
			$qty2+=$qty;
						
			$sizes =  $_POST['dispatch_qnt'][$key];

			$head = "INSERT INTO vodtrnhdr(voTrnType,vTrnCtrlNo,vDocNoPrefix,vDocNo,vDocRsnCd,vDocDt,vDocTime,vPartyType,vPartyId,vPartyStkDocNo,vPartyStkDocDt,vOrdDocType,vTotDocValue,vNetDocValue,vVAUid,vVactr,vVACompCode,vDocRemarks,vTotalLineItems,vSField1,vSField2,vSField3,vSField4,vSField5,vBField1,vBField2,vSHOPERDBVR) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$parameter = array('9800',$trncntrl,$DocNoPrefix,$doc,'',$orderdate,$orderdate,'10',$client,'','01/01/1900 12:00:00 AM','0',$qty2,$qty2,$user,'','L18','',$sizes,'','','','','','FALSE','FALSE','730');
			
			//echo implode(",",$parameter);
			if (sqlsrv_query($conn, $head, $parameter))
			{
				echo "success";
			}
			else
			{
				echo "failed";
			}
			
		}	
		$serial = 1;
		$var = "" ;
		
		foreach($_POST['Stoke_no'] as $key=>$val)
		{
			$product_code = $_POST['Stoke_no'][$key];
			$product_qty = $_POST['dispatch_qnt'][$key];
			$product_price = $_POST['price'][$key];
			$gun = $_POST['dispatch_price'][$key];
			
			$sqlq = "insert into vodtrndtls(vTrnType,vTrnCtrlNo,vDocNoPrefix,vDocNo,vDocRsnCd,vDocDt,vEntSrlNo,vStockNo,vDocQty,vPhyQtyIn,vPhyQtyOut,vStkUpdtRate,vStkUpdtValueIn,vStkUpdtValueOut,vDocEntRate,vDocEntValue,vDocEntNetValue,vDocEntVoidInd,vItemTaxType,vVAUid,vVactr,vVACompCode,vItemMRPBillTm,vBefCurBalQty,vBefCurBalVal,vAftCurBalQty,vAftCurBalVal,vLinkPoDelDate,vDate) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$paramsz = array('9800',$trncntrl,$DocNoPrefix,$doc,'',$orderdate,$serial,$product_code,$product_qty,$product_qty,'0',$product_price,$gun,'0',$product_price,$gun,$gun,'FALSE','02',$user,'','L18','MRPBILL','0.0000','0.0000',$product_qty,$gun,'1/1/1900 12:00:00 AM','');
		
			//$paramsz = implode(",",$paramsz);
		
			if (sqlsrv_query($conn, $sqlq, $paramsz))
			{
				   $var = "1";
			}
			$serial++;
		}

		
		
		
		foreach($_POST['Stoke_no'] as $key=>$val) 
		{
		
		$due_date = date("d/m/Y h:i:s A");
		$cod = "";
		
		$route = $_POST['route'];
		
		$truck = $_POST['truck'];
		
		$new = "select top 1 * from StkTrnHdr where TrnType = 9700 and TrnCtrlNo = '$order_no' ORDER BY DocNo DESC";

		$stmt = sqlsrv_query( $conn, $new );
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			   $RecordSet = $row['DocNo'];
		}
		
		$new2 = "select top 1 * from StkTrnHdr where TrnType = 9700 ORDER BY TrnCtrlNo DESC";
		
		$stmt2 = sqlsrv_query( $conn, $new2 );
		while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
			   $RecordSet2 = $row2['TrnCtrlNo'];
		}
		
		$doc = $RecordSet + 1;
		$trncntrl = $RecordSet2 + 1;
	
		$qty2 = "";
		
		$qty = $_POST['dispatch_price'][$key];
		$qty2+=$qty;
		
		$sizes =  $_POST['dispatch_qnt'][$key];
		
		$head = "insert into StkTrnHdr (TrnType,TrnCtrlNo,DocNoPrefix,DocNo,DocRsnCd,DocDt,DocTime,DocStat,PackCountDoc,PackCountPhy,PartyType,PartyId,PartyStkDocNo,PartyStkDocDt,OrdDocType,OrdDocNoPrefix,OrdDocNo,OrdDocDt,AccDocTyp,AccDocNo,AccDocDt,TotDocValue,TotDocDisc,TotDocTax,TotDocAddons,TotDocDedns,NetDocValue,EnteredSizewise,TaxComp1,TaxComp2,TaxComp3,TaxComp4,TaxComp5,FrwdRefTrnType,FrwdRefCtrlNo,BkwdRefTrnType,BkwdRefCtrlNo,DocVoidInd,BilllvlDiscId,BillPassInd,VAUid,VActr,VATermId,VACompCode,DocRemarks,TotalLineItems,NField1,NField2,NField3,NField4,NField5,DField1,DField2,DField3,BField1,BField2,ProdServInd,TotDocPriceFactor,TotDocED,TotDocEntBefTaxAddons,TotDocEntBefTaxDedns,TotDocEntAftTaxAddons,TotDocEntAftTaxDedns,PromoCode,PromoSlabSrlno,PromoRemarks,PromoType,PromoDefType,PromoIssueTrnType,PromoIssueTrnCtrlNo,PromoFwdLinkType,PromoFwdLinkCtrlNo,PromoBillLevelOfferVal,PromoItemLevelOfferVal,PromoItemLevelDiscVal,PromoBillLevelDiscDtls,ReasonCodeForCancel,GenDiscReason,LinkPOVendor,TotRndOffValue,TotDocAddonsTax,SHOPERDBVER,XS1,XS2,XS3,XS4,XS5,XS6,XS7,XS8,CS1,CS2,CS3,CS4,CS5,CS6,CS7,CS8)
			values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$parameter = array('9800',$trncntrl,'L18CHS15',$doc,'',$orderdate,$orderdate,'','0','0','10',$client,'','1/1/1900 12:00:00 AM','0','','0','1/1/1900 12:00:00 AM','0','','1/1/1900 12:00:00 AM',$qty2,'0','0','0','0',$qty2,'False','0','0','0','0','0','0','0','0','0','0','','0',$user,$user,'001','L18','',$sizes,'0','0','0','0','0','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','False','False','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','730','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');

		//echo implode(",",$parameter);
		
		if (sqlsrv_query($conn, $head, $parameter))
		{
           //echo "success";
    
			$Trnlog = "insert into PrefixTrnLog(Fld1,Fld2,Fld3,Fld4,VaUID,VaCtr,VaTermID,VaCompCode) values (?, ?, ?, ?, ?, ?, ?, ?)";
			$paramtrn = array('<CTRLPX>', '9800', '0', $doc, $user, $user, '', 'L18');
			
			//print_r($paramtrn);
		 	if(sqlsrv_query( $conn, $Trnlog, $paramtrn))
			{
				//echo "hiizxxxxxxz";
				die;
			}

			$Trnlog2 = "insert into PrefixTrnLog(Fld1,Fld2,Fld3,Fld4,VaUID,VaCtr,VaTermID,VaCompCode) values (?, ?, ?, ?, ?, ?, ?, ?)";
	
			$paramtrn2 = array($trncntrl, '9800', '0', $doc, $user, $user, '', 'L18');
	
			sqlsrv_query( $conn, $Trnlog2, $paramtrn2);
			$newdoc = $doc+1;
			$Trnno = "insert into PrefixTrnNo(TrnType,ActualPrefix,DocNumber,IsActive,VaUID,VaCtr,VaTermID,VaCompCode) values (?, ?, ?, ?, ?, ?, ?, ?)";
	
			$paramtrns = array('9800', $trncntrl, $newdoc, '1', $user, $user, '','L18');

		 	sqlsrv_query( $conn, $Trnno, $paramtrns);

			$Trnno2 = "update PrefixTrnNo set DocNumber = ( ?) where ActualPrefix = '<CTRLPX>'";

			$Trnnoparam = array($newdoc, '<CTRLPX>');

		 	sqlsrv_query( $conn, $Trnno2, $Trnnoparam);
	
			$serial = '1';
			$var = "" ;
	
	
			
		$product_code = $_POST['Stoke_no'][$key];
		$product_qty = $_POST['dispatch_qnt'][$key];
		$product_price = $_POST['price'][$key];
		$gun = $_POST['dispatch_price'][$key];
		
		$FindMRP = "select CurrentCost from ItemMaster where StockNo = '$product_code'";

		$stmtMRP = sqlsrv_query($conn, $FindMRP);
		while($rowx = sqlsrv_fetch_array($stmtMRP, SQLSRV_FETCH_ASSOC))
		{
			$MRP = $rowx['CurrentCost'];
		}
		
		$MRPValue = $MRP*$product_qty;
		$sqlq = "insert into StkTrnDtls(TrnType,TrnCtrlNo,DocNoPrefix,DocNo,DocRsnCd,DocDt,EntSrlNo,StockNo,BatchSrlNo,LocnId,OrdDocType,OrdDocNoPrefix,OrdDocNo,OrdEntSrlNo,OrdEntSubSrlNo,RefDocType,RefDocNoPrefix,RefDocNo,RefEntSrlNo,DocQty,PhyQtyIn,PhyQtyOut,StkUpdtRate,StkUpdtValueIn,StkUpdtValueOut,DocEntRate,DocEntValue,DocEntTotDisc,DocEntValAftDisc,DocEntTax,DocEntAddons,DocEntDedns,DocEntNetValue,PhysQtyReturned,DocEntBefTaxAddons,DocEntBefTaxDedns,DocEntAftTaxAddons,DocEntAftTaxDedns,DocEntDisc,DocEntDiscId,DocEntBillDisc,DocEntVoidInd,ItemTaxType,CustTaxType,SrcTaxType,TaxComp1,TaxComp2,TaxComp3,TaxComp4,TaxComp5,RetnReasonCd,FwdRefTrnType,FwdRefCtrlNo,FwdRefDocEntSrlNo,BackRefTrnType,BackRefCtrlNo,BackRefDocEntSrlNo,BillPassInd,VAUid,VActr,VATermId,VACompCode,SalesPersonCd,ItemwiseDiscReason,ExptTrnType,ExptTrnDocPfx,ExptTrnDocNo,ExptTrnDocSrlNo,ExptTrnDocSubSrlNo,EUPCode,ApplPoint,ValuComp,ItemMRPBillTm,ItemCurBalQty,lngAISrlNo,SField5,NField1,NField2,NField3,NField4,NField5,DField1,DField2,DField3,BField1,BField2,ItemLvlPriceFacId,ItemLvlEDId,DocEntPriceFactor,stdTaxComp1Per,DocEntED,stdTaxComp2Per,MerchId,stdTaxComp3Per,stdTaxComp4Per,stdTaxComp5Per,stdTaxComp1Inc,stdTaxComp2Inc,stdTaxComp3Inc,stdTaxComp4Inc,stdTaxComp5Inc,BefCurBalQty,BefCurBalVal,AftCurBalQty,AftCurBalVal,PromoCode,PromoSlabSrlno,PromoRemarks,PromoType,PromoDefType,PromoIssueTrnType,PromoIssueTrnCtrlNo,PromoFwdLinkType,PromoFwdLinkCtrlNo,PromoItemLevelOfferVal,PromoItemlLevelDiscDtls,PromoItemGroup,PromoFlgItemLevel,PromoFlgBillLevel,PromoSetSrlNo,PromoOfferItemType,ItemRemarks,DiscRate,ServicedQty,LinkPOFromLoc,LinkPoType,LinkPoPrefix,LinkPoNumber,LinkPoEntrySrlno,LinkPoEntrySubSrlno,LinkPoDelDate,ServiceLoc,LinkEtTrntype,LinkEtTrnCtrlno,LinkEtDocSubSrlno,TaxRevisionId,ItemTaxFlag,DocEntAddonsTax,DocRndOffValue,TaxAV1,TaxAV2,TaxAV3,TaxAV4,TaxAV5,ProdServInd,XI1,XI2,XI3,XI4,XM1,XM2,XM3,XM4,XD1,XD2,XD3,XD4,CI1,CI2,CI3,CI4,CM1,CM2,CM3,CM4,CD1,CD2,CD3,CD4,MinMOP,MaxMop) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$paramsz = array('9800',$trncntrl,'L18CHS15',$doc,'',$orderdate,$serial,$product_code,'0','0','0','','0','0','0','0','','','0',$product_qty,'0',$product_qty,$product_price,'0',$gun,$MRP,$MRPValue,'0',$MRPValue,'0','0','0',$MRPValue,'0','0','0','0','0','0','0','0','False','02','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',$user,$user,$user,'L18',$user,'','0','','0','0','0','','0','0',$MRPValue,$quantity,'0','1','0','0','3','0','0','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','False','True','0','0','0','0','0','0','0','0','0','0','True','True','True','True','True','4','5','0','0','','0','','0','0','0','0','0','0','0','','0','0','0','0','0','0','0','0','','0','','0','0','0','1/1/1900 12:00:00 AM','','0','0','0','1','2','0','0',$MRPValue,'0','0','0','0','1','0','0','0','0','0','0','0','0','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','0','0','0','0','0','0','0','0','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM','1/1/1900 12:00:00 AM',$MRP,$MRP);
		
		//print_r($paramsz);
		if(sqlsrv_query($conn, $sqlq, $paramsz))
		{
			$var = "1";
			$stockz = "update StockMasterExtd01 set CurBalQty = ((select CurBalQty from StockMasterExtd01 where StockNo = ( ?) and BatchNo = ( ?))- ( ?)), LocationCd = ( ?) where StockNo = ( ?)  and BatchNo = ( ?) ";
			
			$paramz = array($product_code, 'Not Applicable', $product_qty, $truck, $product_code, 'Not Applicable');
			sqlsrv_query( $conn, $stockz, $paramz);
				
			$stockzz = "update StockMasterExtd01 set CurBalVal = ((select CurrentCost from ItemMaster where StockNo = ( ?) )* (Select CurBalQty from StockMasterExtd01 where StockNo = ( ?) and BatchNo = ( ?) )) where StockNo = ( ?)  and BatchNo = ( ?)";

			$paramzz = array($product_code, $product_code, 'Not Applicable', $product_code, 'Not Applicable');

			sqlsrv_query( $conn, $stockzz, $paramzz);
				
				$stockzzz= "update StockMaster set CurBalQty = ((select CurBalQty from StockMaster where StockNo = ( ?))- ( ?)) where StockNo = ( ?)";
				$paramzzz = array($product_code,$product_qty, $product_code);

				if(sqlsrv_query( $conn, $stockzzz, $paramzzz))

				$stockzzzz = "update StockMaster set CurBalVal = ((select CurrentCost from ItemMaster where StockNo = ( ?))* (Select CurBalQty from StockMaster where StockNo = ( ?) )) where StockNo = ( ?) ";
				$paramzzzz = array($product_code, $product_code, $product_code);

				sqlsrv_query( $conn, $stockzzzz, $paramzzzz);
		}
		
		$serial++;
		}	
		
		}
		
		if($var =="1")
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
		
	}
	
	
	
	
?>    

<?php
include("Template/Header.php");
?>

<?php
include("Template/Sidebar.php");
?>
<style>
.margin-top-10px
{
	margin-top:10px;
}
</style>
<script>
function gettruck(){
	  
	   var route = $("#route").val();
			$.ajax({
			  url: "gettruck.php",
			  type: "POST",
			  data : "route="+route,
			  success: function(data) {
				$('#truck').html(data);
				
			  }
			});	
   }
   
  function chkstatus()
  {
	  if($('#order_status').val()=='without_order')
	  {
		$('#dis_orederno').hide(); 
		$('#generate_plan').show(); 	
	  }
	  
	  if($('#order_status').val()=='with_order')
	  {
		$('#dis_orederno').show();
		$('#generate_plan').hide(); 
	  }
  }  
</script>
<style>
.margin-top-5px
{
	margin-top:5px;
}
</style>
<div class="page-container" style="min-height:415px">
<div class="page-content">
<div class="content-wrapper">

<!-- Content area -->
				<div class="content">
                    <div class="panel panel-white">
					<div class="panel-heading">
							<h6 class="panel-title">Dispatch Order</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a><a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
					
				<form action="" method="post">	
					<div class="row">
							<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label>Route:</label>
									<select name="route" id="route" class="select" onChange="gettruck();" >
										<option value="">Select Route</option> 
										<?php
										$sql = "SELECT RouteMastId,RouteName FROM route_master ";
										$stmt = sqlsrv_query( $conn, $sql );
										
										if( $stmt === false ) {
											if( ($errors = sqlsrv_errors() ) != null) {
												foreach( $errors as $error ) {
													echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
													echo "code: ".$error[ 'code']."<br />";
													echo "message: ".$error[ 'message']."<br />";
												}
											}
										}
										
										
										while($row=sqlsrv_fetch_array($stmt))
										{
											?>
											<option value="<?php echo $row['RouteMastId'];?>"><?php echo $row['RouteName'];?></option>
											<?php
										}
									?>		
										
									</select>
								</div>
								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Truck:</label>
									<select name="truck" id="truck" class="select" required="required">
										<option value="">Select Truck</option> 
										 
									</select>
								</div>
							</div>
							
						<div class="row">&nbsp;</div>
						</div>		
						</div>
					<div class="row">
						<div class="col-md-12">
						<div class="col-md-6">
                            <div class="form-group">
                                <select name="order_status" id="order_status" class="select" onChange="chkstatus();">
                                    <option value="">Select Order Status</option> 
                                    <option value="with_order">With Order</option> 
									<option value="without_order">Without Order</option> 		
                                </select>
                            </div>
                        </div>
						<div class="col-md-6" id="dis_orederno">
                            <div class="form-group">
								<input type="text" name="order_no" id="order_no" class="form-control col-md-12" placeholder="Enter Order No">
							</div>
							<br/>
							<div class="form-group margin-top-5px">
								<button type="button" id="get_order_data" class="btn btn-info" name="get_order_data" >Get Stock</button>
							</div>
						</div>
						</div>
						<div class="col-md-12">
						<div id="generate_plan">	
									<div clas="row margin-top-10px">
										
										<div class="col-md-2">
											<label class="control-label">Stoke No</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Product</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Available Qnt</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Price</lable>
										</div>
										<div class="col-md-1">
											<label class="control-label">Dispatch Qnt</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Dispatch Qnt Price</lable>
										</div>
									</div>									
									<div class="row">
										<div class="multi-field-wrapper">
										  <button type="button" class="add-field btn btn-info">+</button>
										  <div class="multi-fields col-md-12">
											<div class="multi-field">
												
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Stoke_No" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Product" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Available Qnt" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Price" value="">
												</div>
												<div class="col-md-1 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Dispatch Qnt" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Dispatch Price" value="">
												</div>
												
												<button type="button" class="remove-field btn btn-info margin-top-10px">-</button>
											</div>	
										</div>
										</div>		
									</div>

									<div class="row margin-top-10px">
									<div class="text-left col-md-12">
										<input type="hidden" readonly="" value="CoursePlanAdd" name="Action">
										<input type="hidden" readonly="" value="3pZYO0Z1fc2suBdwRlRmAcUXLylhP00L72JGav3Mxfybvdfaj" name="RandomNumber">
										<input type="hidden" name="CoursePlanId" value="" readonly>
										<div class="form-row row-fluid">
											<div class="col-md-12">
												<button class="btn btn-info" tabindex="7" type="submit" id="genplan">Generate Plan</button>
											</div>
										</div>
										<br>
										</div>
									</div>
									
									</div>
									
						
					</div>			
					</div>
		        </form>   
					</div>
                    </div>
	
</div>				
</div>				
</div>		
<script>
 $(document).ready(function() {
  $('#dis_orederno').hide();
 
  $('#generate_plan').hide(); 
   
  $('#get_order_data').on('click',function(){
	  
		var order_no = $("#order_no").val();
		
			$.ajax({
			  url: "getstock.php",
			  type: "POST",
			  data : "order_no="+order_no,
			  success: function(data) {
				$('#generate_plan').html(data);
				$('#generate_plan').show(); 
			  }
		});	
  });    
   
   
	$('.multi-field-wrapper').each(function() {
		var $wrapper = $('.multi-fields', this);
		$(".add-field", $(this)).click(function(e) {
			$('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
			//$('.select').select2();
		});
		$('.multi-field .remove-field', $wrapper).click(function() {
			if ($('.multi-field', $wrapper).length > 1)
				$(this).parent('.multi-field').remove();
			
		});
	});
   
    $('.select').select2();
} );

</script>			
