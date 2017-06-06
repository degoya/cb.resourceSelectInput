<?php
/**
 * @var modX $modx
 * @var ContentBlocks $contentBlocks
 * @var array $scriptProperties
 * bind plugin to ContentBlocks_RegisterInputs
 */
if ($modx->event->name == 'ContentBlocks_RegisterInputs') {
    // Load your own class. No need to require cbBaseInput, that's already loaded.
    $path = $modx->getOption('resourceselectinput.core_path', null, MODX_CORE_PATH . 'components/resourceselectinput/');
    require_once($path . 'elements/inputs/resourceselectinput.class.php');

    // Create an instance of your input type, passing the $contentBlocks var
    $instance = new ResourceSelectInput($contentBlocks);

    // Pass back your input reference as key, and the instance as value
    $modx->event->output(array(
        'resourceselectinput' => $instance
    ));
}