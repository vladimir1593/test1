<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	$allUsersLike=array();
	foreach($arResult["ITEMS"] as $key=> $arItem){
		$allUsersLikeId=array_merge($allUsersLike,$arItem["PROPERTIES"]["LIKE"]["VALUE"]);
		
		if($USER->IsAuthorized() && in_array($USER->GetID(),$arItem["PROPERTIES"]["LIKE"]["VALUE"])){
			$arResult["ITEMS"][$key]['USER_LIKE']=true;
		}
	}
	$allUsersLikeId=array_unique($allUsersLikeId);
	$allUsersLikeId=implode(" | ", $allUsersLikeId);
	
	$arResult['allUsersLikeLogin']=array();
	$dbUsers = CUser::GetList($by = 'ID', $order = 'ASC', array("ID"=>$allUsersLikeId),array("SELECT"=>array("LOGIN","ID")));
	while ($arUser = $dbUsers->Fetch()){
		$arResult['allUsersLikeLogin'][$arUser['ID']]=$arUser['LOGIN'];
	}
?>

	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?$this->__template->SetViewTarget("like_".$arItem['ID']);?> 
		<?if(is_array($arItem["PROPERTIES"]['LIKE']['VALUE'])):?>
			<?=$arItem["PROPERTIES"]['LIKE']['NAME'].': '?>
			<?foreach($arItem["PROPERTIES"]['LIKE']['VALUE'] as $val):?>
				<span ><?=$arResult['allUsersLikeLogin'][$val]?> </span>
			<?endforeach?>
		<?endif?>
		<?if ($USER->IsAuthorized()):?>
			<div>
				<a href="<?=$this->__template->GetFolder()?>/ajax.php" rel="<?=$arItem['ID']?>" class="like_btn">
					<?=($arItem['USER_LIKE']) ? GetMessage('NOT_LIKE') : GetMessage('LIKE')?>
				</a>
			</div>
		<?endif?>	
		<?$this->__template->EndViewTarget();?>  
	<?endforeach?>



