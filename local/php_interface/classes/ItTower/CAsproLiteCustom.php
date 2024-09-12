<?php

namespace ItTower\Functions;

use Aspro\Functions\CAsproLite;
use Bitrix\Main\Localization\Loc;
use \CLite as Solution;

class CAsproLiteCustom extends CAsproLite
{
    public static function showHeaderBlock($options)
    {
        $bRestart = $options['AJAX_BLOCK'] == $options['PARAM_NAME'];
        if(!$bRestart && $options['IS_AJAX'] && ($options['AJAX_BLOCK'] != 'HEADER_MAIN_PART' && $options['AJAX_BLOCK'] != 'HEADER_TOP_PART' && $options['AJAX_BLOCK'] != 'HEADER_TOPEST_PART' && $options['AJAX_BLOCK'] != 'HEADER_FIXED_TOP_PART'))
            return false;

        global $APPLICATION;

        if($options['IS_AJAX'] && $bRestart) {
            $APPLICATION->restartBuffer();
        }?>

        <div class="<?=$options['WRAPPER'] ? $options['WRAPPER'] : ''?> <?=$options['VISIBLE'] ? '' : 'hidden'?>" data-ajax-load-block="<?=$options['PARAM_NAME']?>">
            <?if($options['VISIBLE']):?>

                <?
                switch($options['BLOCK_TYPE']) {
                    case 'PHONE':?>
                        <div class="<?=$options['ONLY_ICON'] ? 'icon-block--only_icon' : ''?>">
                            <div class="phones">
                                <?//check phone text?>
                                <div class="phones__phones-wrapper">
                                    <?$svg = $options['ONLY_ICON'] ? 'Phone_big.svg' : 'Phone_black.svg';?>
                                    <?\ItTower\CLiteCustom::ShowHeaderPhones('phones__inner--big', $svg, $options['DROPDOWN_TOP']);?>
                                </div>

                                <?if($options['CALLBACK']):?>
                                    <div>
                                        <div class="phones__callback light-opacity-hover animate-load dark_link banner-light-text menu-light-text <?=$options['CALLBACK_CLASS'] ? $options['CALLBACK_CLASS'] : ''?>" data-event="jqm" data-param-id="<?=\CLite::getFormID("aspro_lite_callback");?>" data-name="callback">
                                            <?=$options['MESSAGE']?>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                        <?break;
                }?>

            <?endif;?>

        </div>


        <?if($options['IS_AJAX'] && $bRestart) {
        die();
    }
    }

    public static function showFooterBlock($options)
    {
        $bRestart = $options['AJAX_BLOCK'] == $options['PARAM_NAME'];
        $bRightIcon = $options['POSITION_ICON'] === 'RIGHT';
        if(!$bRestart && $options['IS_AJAX'] && ($options['AJAX_BLOCK'] != 'FOOTER_MAIN_PART' && $options['AJAX_BLOCK'] != 'FOOTER_TOP_PART' && $options['AJAX_BLOCK'] != 'FOOTER_TOPEST_PART'))
            return false;

        global $APPLICATION;

        if($options['IS_AJAX'] && $bRestart) {
            $APPLICATION->restartBuffer();

            if ($options['BLOCK_TYPE'] === 'DEVELOPER') {
                $APPLICATION->ShowAjaxHead();
            }
        }
        ?>
        <div class="<?=$options['WRAPPER'] ? $options['WRAPPER'] : ''?> <?=$options['VISIBLE'] ? '' : 'hidden'?>" data-ajax-load-block="<?=$options['PARAM_NAME']?>" data-ajax-check-visible="<?=($options['PARAM_CHECK_VISIBLE'] ? $options['PARAM_CHECK_VISIBLE'] : '');?>">

            <?if($options['TITLE']):?>
                <div class="footer__title font_weight--600 font_short">
                    <?=$options['TITLE'];?>
                </div>
            <?endif;?>

            <?if($options['INNER_WRAPPER']):?>
            <div class="<?=$options['INNER_WRAPPER']?>">
                <?endif;?>

                <?if($options['VISIBLE']):?>
                    <?
                    switch($options['BLOCK_TYPE']) {
                        case 'SUBSCRIBE':?>
                            <?if (\Bitrix\Main\ModuleManager::isModuleInstalled("subscribe")):?>
                                <?if ($options['COMPACT']):?>
                                    <div class="stroke-theme-parent-all color-theme-parent-all">
                                        <div class="icon-block icon-block--with_icon" data-event="jqm" data-param-type="subscribe" data-name="subscribe">

                                            <?if ($options['BTN_CLASS']):?>
                                            <div class="<?=$options['BTN_CLASS']?>">
                                                <?endif;?>

                                                <div class="subscribe icon-block__wrapper <?=($bRightIcon ? 'flexbox--direction-row-reverse' : '');?>">
                                                    <span class="icon-block__icon icon-block__only-icon <?=($bRightIcon ? 'icon-block__icon--right' : '');?> stroke-theme-target banner-light-icon-fill menu-light-icon-fill light-opacity-hover"><?=\CLite::showIconSvg('subscribe', SITE_TEMPLATE_PATH.'/images/svg/Subscribe_sm.svg');?></span>
                                                    <div class="subscribe__text color-theme-target icon-block__name font_<?=($options['FONT_SIZE'] ? $options['FONT_SIZE'] : 13);?> color_999"><?=Loc::getMessage('SUBSCRIBE');?></div>
                                                </div>

                                                <?if ($options['BTN_CLASS']):?>
                                            </div>
                                        <?endif;?>

                                        </div>
                                    </div>
                                <?elseif (\CLite::checkContentFile(SITE_DIR.'include/footer/subscribe.php')):?>
                                    <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/footer/subscribe.php';?>
                                <?endif;?>
                            <?endif;?>
                            <?break;
                        case 'ADDRESS':?>
                            <div class="<?=$options['NO_ICON'] ? '' : 'icon-block--with_icon'?>">
                                <?
                                \CLite::showAddress(
                                    array(
                                        'CLASS' => 'address',
                                        'FONT_SIZE' => '15',
                                        'SHOW_SVG' => false,
                                    )
                                );?>
                            </div>
                            <?break;
                        case 'EMAIL':?>
                            <div class="<?=$options['NO_ICON'] ? '' : 'icon-block--with_icon'?>">
                                <?
                                \CLite::showEmail(
                                    array(
                                        'CLASS' => 'footer__email font_15 font_short',
                                        'LINK_CLASS' => 'dark_link',
                                        'SHOW_SVG' => false,
                                    )
                                );?>
                            </div>
                            <?break;
                        case 'SOCIAL':?>
                            <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/footer/social.info.php';?>
                            <?break;
                        case 'PHONE':?>
                            <div class="<?=$options['ONLY_ICON'] ? 'icon-block--only_icon' : ''?>">
                                <div class="phones">
                                    <?//check phone text?>
                                    <div class="phones__phones-wrapper">
                                        <?//$svg = $options['ONLY_ICON'] ? 'Phone_big.svg' : 'Phone_black.svg';?>
                                        <?\ItTower\CLiteCustom::ShowHeaderPhones('phones__inner--big', "", $options['DROPDOWN_TOP']);?>
                                    </div>

                                    <?if($options['CALLBACK']):?>
                                        <div>
                                            <div class="phones__callback light-opacity-hover animate-load colored banner-light-text menu-light-text <?=$options['CALLBACK_CLASS'] ? $options['CALLBACK_CLASS'] : ''?>" data-event="jqm" data-param-id="<?=\CLite::getFormID("aspro_lite_callback");?>" data-name="callback">
                                                <?=$options['MESSAGE']?>
                                            </div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <?break;
                        case 'LANG':?>
                            <div class="<?=$options['NO_ICON'] ? '' : 'icon-block--with_icon'?> <?=$options['ONLY_ICON'] ? 'icon-block--only_icon' : ''?>">
                                <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'/include/header/site.selector.php';?>
                            </div>
                            <?break;
                        case 'PAY_SYSTEMS':?>
                            <?if(\CLite::checkContentFile(SITE_DIR.'include/footer/pay_system_icons.php')):?>
                                <?$APPLICATION->IncludeFile(SITE_DIR."include/footer/pay_system_icons.php", Array(), Array(
                                        "MODE" => "php",
                                        "NAME" => "Payment systems",
                                        "TEMPLATE" => "include_area.php",
                                    )
                                );?>
                            <?endif;?>
                            <?break;
                        case 'DEVELOPER':?>
                            <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/footer/developer.php';?>
                            <?break;
                        case 'FOOTER_ALL_BLOCK':?>
                            <?if ($options['ITEMS']) {
                                foreach ($options['ITEMS'] as $arOption) {
                                    self::showFooterBlock($arOption);
                                }
                            }?>
                            <?break;
                    }?>

                <?endif;?>

                <?if($options['INNER_WRAPPER']):?>
            </div>
        <?endif;?>

        </div>


        <?if($options['IS_AJAX'] && $bRestart) {
        die();
    }
    }

    public static function showMobileHeaderBlock($options)
    {
        $bRestart = $options['AJAX_BLOCK'] == $options['PARAM_NAME'];
        if(
            !$bRestart &&
            $options['IS_AJAX'] &&
            (
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_MAIN_PART' &&
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_TOGGLE_PHONE' &&
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_TOGGLE_SEARCH' &&
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_TOGGLE_PERSONAL' &&
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_TOGGLE_COMPARE' &&
                $options['AJAX_BLOCK'] != 'HEADER_MOBILE_TOGGLE_CART'
            )
        ){
            return false;
        }

        if(!$options['VISIBLE']){
            return false;
        }

        global $APPLICATION;

        $class = ($options['WRAPPER'] ? $options['WRAPPER'] : '');
        $class .= ($options['VISIBLE'] ? '' : ' hidden');

        if($options['IS_AJAX'] && $bRestart) {
            $APPLICATION->restartBuffer();
        }
        ?>
        <div <?=($class ? 'class="'.$class.'"' : '')?> data-ajax-load-block="<?=$options['PARAM_NAME']?>">
            <?
            switch($options['BLOCK_TYPE']) {
                case 'SEARCH':?>
                    <div class="header-search__mobile banner-light-icon-fill fill-dark-light-block fill-theme-hover color-theme-hover menu-light-icon-fill light-opacity-hover" title="<?=GetMessage("SEARCH_TITLE")?>">
                        <?= Solution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/header_icons.svg#search-18-18', 'header__icon header-search__icon', ['WIDTH' => 18, 'HEIGHT' => 18]); ?>
                    </div>
                    <?break;
                case 'PHONE':?>
                    <div class="icon-block--with_icon icon-block--only_icon">
                        <div class="phones">
                            <div class="phones__phones-wrapper">
                                <?
                                \ItTower\CLiteCustom::ShowHeaderMobilePhones([
                                    'CALLBACK' => $options['CALLBACK'],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <?break;
                case 'BURGER':?>
                    <div class="burger light-opacity-hover fill-theme-hover banner-light-icon-fill menu-light-icon-fill fill-dark-light-block">
                        <?= Solution::showSpriteIconSvg(SITE_TEMPLATE_PATH . '/images/svg/header_icons.svg#burger-16-12', '', ['WIDTH' => 16, 'HEIGHT' => 12]); ?>
                    </div>
                    <?break;
                case 'CABINET':?>
                    <div class="header-cabinet">
                        <?$arCabinetParams = $options['CABINET_PARAMS'] ? $options['CABINET_PARAMS'] : array();?>
                        <?= Solution::showCabinetLink($arCabinetParams); ?>
                    </div>
                    <?break;
                case 'COMPARE':?>
                    <div class="header-compare js-compare-block-wrapper">
                        <?= Solution::showCompareLink($options['CLASS_LINK'], $options['CLASS_ICON'], $options['MESSAGE']); ?>
                    </div>
                    <?break;
                case 'FAVORITE':?>
                    <div class="header-favorite js-compare-block-wrapper">
                        <?= Solution::showFavoriteLink($options['CLASS_LINK'], $options['CLASS_ICON'], $options['MESSAGE']); ?>
                    </div>
                    <?break;
                case 'BASKET':?>
                    <div class="header-cart">
                        <?= Solution::showBasketLink($options['CLASS_LINK'], $options['CLASS_ICON'], $options['MESSAGE']); ?>
                    </div>
                    <?break;
            }?>
        </div>
        <?
        if($options['IS_AJAX'] && $bRestart) {
            die();
        }
    }

    public static function showMobileMenuBlock($options)
    {
        $bRestart = $options['AJAX_BLOCK'] == $options['PARAM_NAME'];
        if(
            !$bRestart &&
            $options['IS_AJAX'] &&
            (
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_MAIN_PART' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_CONTACTS' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_SOCIAL' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_LANG' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_REGION' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_PERSONAL' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_CART' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_COMPARE' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_BUTTON' &&
                $options['AJAX_BLOCK'] != 'MOBILE_MENU_TOGGLE_FAVORITE'
            )
        ){
            return false;
        }

        if(!$options['VISIBLE']){
            return false;
        }

        global $APPLICATION;

        $class = ($options['WRAPPER'] ? $options['WRAPPER'] : '');
        $class .= ($options['VISIBLE'] ? '' : ' hidden');

        if($options['IS_AJAX'] && $bRestart) {
            $APPLICATION->restartBuffer();
        }
        ?>
        <div <?=($class ? 'class="'.$class.'"' : '')?> data-ajax-load-block="<?=$options['PARAM_NAME']?>">
            <?
            switch($options['BLOCK_TYPE']) {
                case 'CONTACTS':?>
                    <div class="mobilemenu__menu mobilemenu__menu--contacts">
                        <ul class="mobilemenu__menu-list">
                            <?if($options['PHONES']):?>
                                <?
                                $blockOptions = [
                                    'CALLBACK' => $options['CALLBACK'],
                                    'SHOW_SVG' => false,
                                ];

                                \ItTower\CliteCustom::ShowMobileMenuPhones($blockOptions);
                                ?>
                            <?endif;?>

                            <?if($options['EMAIL']):?>
                                <?
                                $blockOptions = [
                                    'CLASS' => 'link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all',
                                    'SHOW_SVG' => false,
                                    'CLASS_SVG' => 'email mobilemenu__menu-item-svg fill-theme-target',
                                    'SVG_NAME' => 'Email_big.svg',
                                    'TITLE' => '',
                                    'TITLE_CLASS' => '',
                                    'LINK_CLASS' => 'icon-block__content dark_link',
                                    'WRAPPER' => 'mobilemenu__menu-item-content',
                                ];
                                ?>
                                <?ob_start();?>
                                <?Solution::showEmail($blockOptions);?>
                                <?$emailHtml = trim(ob_get_clean());?>
                                <?if(strlen($emailHtml)):?>
                                    <li class="mobilemenu__menu-item mobilemenu__menu-item--full-height<?= $blockOptions['SHOW_SVG'] ? ' mobilemenu__menu-item--with-icon' : ''; ?>"><?=$emailHtml?></li>
                                <?endif;?>
                            <?endif;?>

                            <?if($options['ADDRESS']):?>
                                <?
                                $blockOptions = [
                                    'CLASS' => 'link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all',
                                    'SHOW_SVG' => false,
                                    'CLASS_SVG' => 'address mobilemenu__menu-item-svg fill-theme-target',
                                    'SVG_NAME' => 'Address_big.svg',
                                    'TITLE' => '',
                                    'TITLE_CLASS' => '',
                                    'WRAPPER' => 'mobilemenu__menu-item-content',
                                    'NO_LIGHT' => true,
                                    'LARGE' => false,
                                ];
                                ?>
                                <?ob_start();?>
                                <?Solution::showAddress($blockOptions);?>
                                <?$addressHtml = trim(ob_get_clean());?>
                                <?if(strlen($addressHtml)):?>
                                    <li class="mobilemenu__menu-item mobilemenu__menu-item--full-height<?= $blockOptions['SHOW_SVG'] ? ' mobilemenu__menu-item--with-icon' : ''; ?>"><?=$addressHtml?></li>
                                <?endif;?>
                            <?endif;?>

                            <?if($options['SCHEDULE']):?>
                                <?
                                $blockOptions = [
                                    'CLASS' => 'link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all',
                                    'SHOW_SVG' => false,
                                    'CLASS_SVG' => 'schedule mobilemenu__menu-item-svg fill-theme-target',
                                    'TITLE' => '',
                                    'TITLE_CLASS' => '',
                                    'WRAPPER' => 'mobilemenu__menu-item-content',
                                ];
                                ?>
                                <?ob_start();?>
                                <?Solution::showSchedule($blockOptions);?>
                                <?$scheduleHtml = trim(ob_get_clean());?>
                                <?if(strlen($scheduleHtml)):?>
                                    <li class="mobilemenu__menu-item mobilemenu__menu-item--full-height<?= $blockOptions['SHOW_SVG'] ? ' mobilemenu__menu-item--with-icon' : ''; ?>"><?=$scheduleHtml?></li>
                                <?endif;?>
                            <?endif;?>
                        </ul>
                    </div>
                    <?break;
                case 'SOCIAL':?>
                    <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/mobile-social.info.php';?>
                    <?break;
                case 'LANG':?>
                    <?include $_SERVER['DOCUMENT_ROOT'].SITE_DIR.'/include/header/site.selector.php';?>
                    <?break;
                case 'REGION':?>
                    <?Solution::ShowMobileMenuRegions();?>
                    <?break;
                case 'CABINET':?>
                    <?Solution::ShowMobileMenuCabinet();?>
                    <?break;
                case 'COMPARE':?>
                    <?Solution::ShowMobileMenuCompare();?>
                    <?break;
                case 'BASKET':?>
                    <?Solution::ShowMobileMenuBasket();?>
                    <?break;
                case 'FAVORITE':?>
                    <?Solution::ShowMobileMenuFavorite();?>
                    <?break;
            }?>
        </div>
        <?
        if($options['IS_AJAX'] && $bRestart) {
            die();
        }
    }


}