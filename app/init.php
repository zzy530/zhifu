<?php

Model::load(array('AppModel', 'BelongType', 'Word', 'Option'));

App::load('util', 'TrieTree');
App::load('util', 'FileSystem');

include(LIB_DIR.'/AppController.php');
include(LIB_DIR.'/functions.php');