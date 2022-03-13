<?php
// HELPER FUNC
function dump($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

global $tree;

$list = file_get_contents('list.json');
$list = json_decode($list, true);
$tree = file_get_contents('tree.json');
$tree = json_decode($tree, true);

global $categories;

foreach ($list as $elem)
{
    $categories[$elem['category_id']] = $elem['translations']['pl_PL']['name'];
}

dump($categories);

global $output;
global $iter;

function test($array)
{
    global $categories;
    global $output;
    global $iter;

    foreach ($array as $elem) {
        if (array_key_exists($elem['id'], $categories)) {
            $output[$iter]['id'] = $elem['id'] . ' ';
            $output[$iter]['name'] = $categories[$elem['id']];
            $output[$iter]['children'] = [];
            $iter++;
        }

        if (is_array($elem['children']) && !empty($elem['children'])) {
            test($elem['children']);
        }
    }
}

test($tree);
dump($output);

