<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CModule::IncludeModule("iblock") || !$USER->IsAuthorized())
	exit();
	
global $USER;

$elId=intval($_REQUEST['id']);
$userId=$USER->GetID();
$iblockId=CIBlockElement::GetIBlockByID($elId);

if($elId>0){
	$db_props = CIBlockElement::GetProperty($iblockId, $elId, array("id" => "asc"), Array("CODE"=>"LIKE"));
	$propLikeValue=array();
	while ($prop = $db_props->GetNext()){
		$propLikeValue[]=$prop['VALUE'];
	}
	$key = array_search($userId, $propLikeValue);
	if ($key !== false){
		unset($propLikeValue[$key]);
		echo 0;
	}
	else{
		$propLikeValue[]=$userId;
		echo 1;
	}
	if(count($propLikeValue)<=0) $propLikeValue=''; 
	CIBlockElement::SetPropertyValuesEx($elId, $iblockId, array('LIKE' => $propLikeValue));
}
?>