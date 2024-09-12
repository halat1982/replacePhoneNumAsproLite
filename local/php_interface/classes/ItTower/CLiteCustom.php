<?php

namespace ItTower;
use Bitrix\Main\Localization\Loc;

class CLiteCustom extends \CLite
{

    public static function ShowHeaderPhones($class = '', $icon = '', $dropdownTop = false){
        static $iCalledID;
        ++$iCalledID;

        global $APPLICATION, $arRegion;

        $arBackParametrs = self::GetBackParametrsValues(SITE_ID);
        $iCountPhones = ($arRegion ? count($arRegion['PHONES']) : $arBackParametrs['HEADER_PHONES']);
        $p = new Phones();
        $p->getPhones($iCountPhones, $arBackParametrs);
        ?>
        <?if($arRegion):?>
            <?$frame = new \Bitrix\Main\Page\FrameHelper('header-allphones-block'.$iCalledID);?>
            <?$frame->begin();?>
        <?endif;?>

        <?if($iCountPhones): // count of phones?>
            <?
            $phone = ($arRegion ? $arRegion['PHONES'][0] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_0']);
            $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
            if(!strlen($href)){
                $href = 'javascript:;';
            }
            $bDropDownPhones = ((int)$iCountPhones > 1);
            ?>
            <div class="phones__inner<?=($bDropDownPhones ? ' phones__inner--with_dropdown' : '')?><?=($class ? ' '.$class : '')?> fill-theme-parent">
                <a class="phones__phone-link phones__phone-first dark_link banner-light-text menu-light-text icon-block__name" href="<?=$href?>"><?=$phone?></a>
                <?if($iCountPhones > 1): // if more than one?>
                    <div class="phones__dropdown <?=$dropdownTop ? 'phones__dropdown--top' : ''?>">
                        <div class="dropdown dropdown--relative">
                            <?for($i = 0; $i < $iCountPhones; ++$i):?>
                                <?
                                $phone = ($arRegion ? $arRegion['PHONES'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_'.$i]);
                                $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
                                if(!strlen($href)){
                                    $href = 'javascript:;';
                                }
                                $description = ($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_'.$i]);
                                $description = (strlen($description) ? '<span class="phones__phone-descript phones__dropdown-title">'.$description.'</span>' : '');
                                ?>
                                <div class="phones__phone-more dropdown__item color-theme-hover <?=$i == 0 ? 'dropdown__item--first' : ''?> <?=$i == $iCountPhones - 1 ? 'dropdown__item--last' : ''?>">
                                    <a class="phones__phone-link dark_link <?=(strlen($description) ? '' : 'phones__phone-link--no_descript')?>" rel="nofollow" href="<?=$href?>"><?=$phone?><?=$description?></a>
                                </div>
                            <?endfor;?>
                            <div class="phones__dropdown-item callback-item">
                                <div class="animate-load btn btn-default btn-wide btn-sm" data-event="jqm" data-param-id="<?=self::getFormID("aspro_lite_callback");?>" data-name="callback">
                                    <?=GetMessage('CALLBACK')?>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown dropdown--relative">
                            <?
                            self::showEmail(
                                array(
                                    'CLASS' => 'phones__dropdown-value',
                                    'SHOW_SVG' => false,
                                    'TITLE' => GetMessage('EMAIL'),
                                    'TITLE_CLASS' => 'phones__dropdown-title',
                                    'LINK_CLASS' => 'dark_link',
                                    'WRAPPER' => 'phones__dropdown-item',
                                )
                            );

                            self::showAddress(
                                array(
                                    'CLASS' => 'phones__dropdown-value',
                                    'SHOW_SVG' => false,
                                    'TITLE' => GetMessage('ADDRESS'),
                                    'TITLE_CLASS' => 'phones__dropdown-title',
                                    'WRAPPER' => 'phones__dropdown-item',
                                    'NO_LIGHT' => true,
                                    'LARGE' => true,
                                )
                            );

                            self::showSchedule(
                                array(
                                    'CLASS' => 'phones__dropdown-value',
                                    'SHOW_SVG' => false,
                                    'TITLE' => GetMessage('SCHEDULE'),
                                    'TITLE_CLASS' => 'phones__dropdown-title',
                                    'WRAPPER' => 'phones__dropdown-item',
                                    'NO_LIGHT' => true,
                                    'LARGE' => true,
                                )
                            );

                            include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/phones-social.info.php';
                            ?>
                        </div>
                    </div>
                    <span class="more-arrow banner-light-icon-fill menu-light-icon-fill fill-dark-light-block">
						<?=self::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/arrows.svg#down-7-5', '', ['WIDTH' => 7,'HEIGHT' => 5]);?>
                        <?//=self::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/more_arrow.svg", "", "", false);?>
					</span>
                <?endif;?>
            </div>
            <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/phones.js');?>
        <?endif;?>
        <?if($arRegion):?>
            <?$frame->end();?>
        <?endif;?>
        <?
    }

    public static function ShowMobileMenuPhones($arOptions = array()){
        static $iCalledID;
        ++$iCalledID;

        global $arRegion, $arTheme;

        $arDefaulOptions = array(
            'CLASS' => '',
            'CALLBACK' => true,
        );
        $arOptions = array_merge($arDefaulOptions, $arOptions);

        if($arRegion){
            Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('mobilemenu__phone'.$iCalledID);
        }

        $arBackParametrs = self::GetBackParametrsValues(SITE_ID);
        $iCountPhones = ($arRegion ? count($arRegion['PHONES']) : $arBackParametrs['HEADER_PHONES']);

        $p = new Phones();
        $p->getPhones($iCountPhones, $arBackParametrs);

        if($iCountPhones){
            $phone = ($arRegion ? $arRegion['PHONES'][0] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_0']);
            $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
            if(!strlen($href)){
                $href = 'javascript:;';
            }
            $description = ($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][0] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_0']);
            ?>
            <li class="mobilemenu__menu-item mobilemenu__menu-item--parent<?= $arOptions['SHOW_SVG'] ? ' mobilemenu__menu-item--with-icon' : ''; ?>">
                <div class="link-wrapper fill-theme-parent-all color-theme-parent-all">
                    <a class="dark_link icon-block" href="<?=$href?>" rel="nofollow">
                        <? if ($arOptions['SHOW_SVG']): ?>
                            <?= self::showIconSvg('phone mobilemenu__menu-item-svg fill-theme-target', SITE_TEMPLATE_PATH."/images/svg/Phone_big.svg"); ?>
                        <? endif; ?>
                        <span class="icon-block__content">
							<span class="font_18"><?=$phone?></span>
							<?if(strlen($description)):?>
                                <span class="font_12 color_999 phones__phone-descript"><?=$description?></span>
                            <?endif;?>
                            <?= self::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/arrows.svg#right-7-5', 'down menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light-block', ['WIDTH' => 7, 'HEIGHT' => 5]); ?>
						</span>

                        <span class="toggle_block"></span>
                    </a>
                </div>
                <ul class="mobilemenu__menu-dropdown dropdown">
                    <li class="mobilemenu__menu-item mobilemenu__menu-item--back">
                        <div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block color-theme-parent-all">
                            <a class="dark_link arrow-all stroke-theme-target" href="" rel="nofollow">
                                <?= self::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/arrows.svg#left-7-12', 'arrow-all__item-arrow', ['WIDTH' => 7, 'HEIGHT' => 12]); ?>
                                <?= GetMessage('LITE_T_MENU_BACK'); ?>
                            </a>
                        </div>
                    </li>
                    <li class="mobilemenu__menu-item mobilemenu__menu-item--title">
                        <div class="link-wrapper">
                            <a class="dark_link" href="">
                                <span class="font_18 font_bold"><?=Loc::getMessage('LITE_T_MENU_CALLBACK')?></span>
                            </a>
                        </div>
                    </li>
                    <?for($i = 0; $i < $iCountPhones; ++$i):?>
                        <?
                        $phone = ($arRegion ? $arRegion['PHONES'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_'.$i]);
                        $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
                        if(!strlen($href)){
                            $href = 'javascript:;';
                        }
                        $description = ($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_'.$i]);
                        ?>
                        <li class="mobilemenu__menu-item">
                            <div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all">
                                <a class="dark_link phone" href="<?=$href?>" rel="nofollow">
                                    <span class="font_18"><?=$phone?></span>
                                    <?if(strlen($description)):?>
                                        <span class="font_12 color_999 phones__phone-descript"><?=$description?></span>
                                    <?endif;?>
                                </a>
                            </div>
                        </li>
                    <?endfor;?>

                    <?if($arOptions['CALLBACK']):?>
                        <li class="mobilemenu__menu-item mobilemenu__menu-item--callback">
                            <div class="animate-load btn btn-default btn-transparent-border btn-wide" data-event="jqm" data-param-id="<?=self::getFormID("aspro_lite_callback");?>" data-name="callback">
                                <?=GetMessage('CALLBACK')?>
                            </div>
                        </li>
                    <?endif;?>
                </ul>
            </li>
            <?
        }

        if($arRegion){
            Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('mobilemenu__phone'.$iCalledID);
        }
    }

    public static function ShowHeaderMobilePhones($arOptions = array()){
        static $iCalledID;
        ++$iCalledID;

        global $arRegion, $arTheme, $APPLICATION;

        $arDefaulOptions = array(
            'CLASS' => '',
            'CALLBACK' => true,
        );
        $arOptions = array_merge($arDefaulOptions, $arOptions);

        $arBackParametrs = self::GetBackParametrsValues(SITE_ID);
        $iCountPhones = ($arRegion ? count($arRegion['PHONES']) : $arBackParametrs['HEADER_PHONES']);
        $p = new Phones();
        $p->getPhones($iCountPhones, $arBackParametrs);
        ?>
        <?if($arRegion):?>
            <?
            $frame = new \Bitrix\Main\Page\FrameHelper('header-allphones-block'.$iCalledID);
            $frame->begin();
            ?>
        <?endif;?>
        <?if($iCountPhones): // count of phones?>
            <?
            $phone = ($arRegion ? $arRegion['PHONES'][0] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_0']);
            $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
            if(!strlen($href)){
                $href = 'javascript:;';
            }
            ?>
            <div class="phones__inner phones__inner--with_dropdown <?=$arOptions['CLASS']?> fill-theme-parent">
				<span class="icon-block__only-icon fill-theme-hover menu-light-icon-fill fill-dark-light-block fill-theme-target">
					<?= self::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/header_icons.svg#phone-14-18', 'header__icon', ['WIDTH' => 14, 'HEIGHT' => 18]); ?>
				</span>
                <div id="mobilephones" class="phones__dropdown">
                    <div class="mobilephones__menu-dropdown dropdown dropdown--relative">
                        <?// close icon?>
                        <span class="mobilephones__close fill-dark-light fill-theme-hover" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>">
							<?= self::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/header_icons.svg#close-16-16', '', ['WIDTH' => 16, 'HEIGHT' => 16]); ?>
						</span>

                        <div class="mobilephones__menu-item mobilephones__menu-item--title">
                            <span class="color_222 font_18 font_bold"><?=Loc::getMessage('LITE_T_MENU_CALLBACK')?></span>
                        </div>

                        <?for($i = 0; $i < $iCountPhones; ++$i):?>
                            <?
                            $phone = ($arRegion ? $arRegion['PHONES'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_VALUE_'.$i]);
                            $href = 'tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone);
                            if(!strlen($href)){
                                $href = 'javascript:;';
                            }
                            $description = ($arRegion ? $arRegion['PROPERTY_PHONES_DESCRIPTION'][$i] : $arBackParametrs['HEADER_PHONES_array_PHONE_DESCRIPTION_'.$i]);
                            ?>
                            <div class="mobilephones__menu-item">
                                <div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all">
                                    <a class="dark_link phone" href="<?=$href?>" rel="nofollow">
                                        <span class="font_18"><?=$phone?></span>
                                        <?if(strlen($description)):?>
                                            <span class="font_12 color_999 phones__phone-descript"><?=$description?></span>
                                        <?endif;?>
                                    </a>
                                </div>
                            </div>
                        <?endfor;?>

                        <?if($arOptions['CALLBACK']):?>
                            <div class="mobilephones__menu-item mobilephones__menu-item--callback">
                                <div class="animate-load btn btn-default btn-transparent-border btn-wide" data-event="jqm" data-param-id="<?=self::getFormID("aspro_lite_callback");?>" data-name="callback">
                                    <?=GetMessage('CALLBACK')?>
                                </div>
                            </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        <?endif;?>
        <?if($arRegion):?>
            <?$frame->end();?>
        <?endif;?>
        <?
    }
}



class Phones
{
    private $isGoogle = false;

    private $isYandex = false;

    private $isInstagram = false;

    public function getPhones(&$iCountPhones, &$arBackParametrs)
    {

        $this->checkUtm();
        $this->checkCookie();

        if ($phone = $this->getGooglePhone()){
            $this->addPhone($phone, $arBackParametrs,$iCountPhones);
        }
        if ($phone = $this->getYandexPhone()){
            $this->addPhone($phone, $arBackParametrs, $iCountPhones);
        }
        if ($phone = $this->getInstagramPhone()){
            $this->addPhone($phone, $arBackParametrs, $iCountPhones);
        }
    }

    public function getShowroomPhone()
    {

        $this->checkUtm();
        $this->checkCookie();

        $phoneData = array(
            "PHONE" => "+375 (29) 111-11-11",
            "CLEARED_PHONE" => "+375291111111"
        );

        if ($phone = $this->getGooglePhone()){
            $phoneData = $this->getPhoneData($phone);
        }
        if ($phone = $this->getYandexPhone()){
            $phoneData = $this->getPhoneData($phone);
        }
        if ($phone = $this->getInstagramPhone()){
            $phoneData = $this->getPhoneData($phone);
        }

        return $phoneData;
    }

    protected function getPhoneData($phone)
    {
        $phoneData = array();
        $phoneData["PHONE"] = $phone;
        $phoneData["CLEARED_PHONE"] = str_replace([" ", "-", "(", ")"], [""], $phone);

        return $phoneData;

    }

    private function addPhone($phone, &$arrayTo, &$iCountPhones){
        $oldPhoneArr = array();
        for($i=0; $i < $iCountPhones; $i++) {
            $oldPhoneArr["HEADER_PHONES_array_PHONE_VALUE_".$i] = $arrayTo["HEADER_PHONES_array_PHONE_VALUE_".$i];
            $oldPhoneArr["HEADER_PHONES_array_PHONE_DESCRIPTION".$i] = $arrayTo["HEADER_PHONES_array_PHONE_DESCRIPTION".$i];
        }
        $iCountPhones++;

        $arrayTo["HEADER_PHONES_array_PHONE_VALUE_0"] = $phone;
        $arrayTo["HEADER_PHONES_array_PHONE_DESCRIPTION_0"] = "A1";
        for($i = 0; $i < $iCountPhones; $i++){
            $arrayTo["HEADER_PHONES_array_PHONE_VALUE_".$i+1] = $oldPhoneArr["HEADER_PHONES_array_PHONE_VALUE_".$i];
            $arrayTo["HEADER_PHONES_array_PHONE_DESCRIPTION_".$i+1] = $oldPhoneArr["HEADER_PHONES_array_PHONE_DESCRIPTION".$i];
        }
    }

    private function checkUtm()
    {
        if (isset($_GET['utm_source'], $_GET['utm_medium'])){
            if (($_GET['utm_source'] === 'google') && ($_GET['utm_medium'] === 'cpc')){
                $this->isGoogle = true;
                $this->isYandex = false;
                $this->isInstagram = false;
                setcookie('tel_i', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_y', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_g', '1', time() + 3600*24*30,'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
            }
            if (($_GET['utm_source'] === 'yandex') && ($_GET['utm_medium'] === 'cpc')){
                $this->isYandex = true;
                $this->isGoogle = false;
                $this->isInstagram = false;
                setcookie('tel_i', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_g', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_y', '1', time() + 3600*24*30,'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
            }
            if (($_GET['utm_source'] === 'instagram') && ($_GET['utm_medium'] === 'target')){
                $this->isInstagram = true;
                $this->isGoogle = false;
                $this->isYandex = false;
                setcookie('tel_g', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_y', '0', time(),'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
                setcookie('tel_i', '1', time() + 3600*24*30,'/','',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'],true);
            }
        }
    }

    private function checkCookie()
    {
        if (!($this->isGoogle || $this->isYandex || $this->isInstagram)){
            if (isset($_COOKIE['tel_g'])){
                $this->isGoogle = true;
            }
            if (isset($_COOKIE['tel_y'])){
                $this->isYandex = true;
            }
            if (isset($_COOKIE['tel_i'])){
                $this->isInstagram = true;
            }
        }
    }

    private function getGooglePhone()
    {      

        return $this->isGoogle ? "+375 (29) XXX-XX-XX" : false;
    }

    private function getYandexPhone()
    {      

        return $this->isYandex ? "+375 (29) XXX-XX-XX" : false;
    }

    private function getInstagramPhone()
    {
        
        return $this->isInstagram ? "+375 (29) XXX-XX-XX" : false;
    }


}