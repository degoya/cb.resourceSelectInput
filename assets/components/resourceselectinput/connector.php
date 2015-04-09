<?php
/**
 * resourceselect input for ContentBlocks 
 *
 * Copyright 2015 by Alexander Herling <kontakt@degoya.de>
 *
 * @package resourceselectinput
 * @var modX $modx
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('resourceselectinput.core_path',null,$modx->getOption('core_path').'components/resourceselectinput/');
$path = $corePath . 'processors/';
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
 