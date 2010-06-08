<?php

require dirname(__FILE__).'/../../bootstrap/functional.php';
require_once $configuration->getSymfonyLibDir().'/vendor/lime/lime.php';

$t = new lime_test(2);
$configuration->loadHelpers('InlineObject');

$text = '[image:flower.jpg format="test" link="true" alt="testing flower"]';
$rendered = parse_inline_object($text);
$expected = sprintf('<a class="inline_image" href="%s">%s</a>', image_path('/uploads/flower.jpg'), image_tag('/uploads/flower.jpg', array('alt' => 'testing flower')));
$t->is($rendered, $expected, sprintf('%s renders as %s', $text, $expected));

$text = '[image:flower.jpg]';
$rendered = parse_inline_object($text);
$expected = image_tag('/uploads/flower.jpg');
$t->is($rendered, $expected, sprintf('%s renders as %s', $text, $expected));