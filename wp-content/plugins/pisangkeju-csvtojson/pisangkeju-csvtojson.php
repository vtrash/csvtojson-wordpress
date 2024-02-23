<?php

/**
 * Plugin Name: PisangKeju CSVtoJSON
 * Plugin URI:  https://vtrash00.netlify.app/
 * Author:      PisangKeju
 * Author URI:  https://vtrash00.netlify.app/
 * Description: Convert .csv to json for pricing rules.
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: pisangkeju-csvtojson
 */

use function PHPSTORM_META\map;

if (!defined("WPINC")) {
    exit("Do not access this file directly.");
}


//deinf plugin constants
define("PISANGKEJU_CSVTOJSON_VERSION", time());
//plugin file
define("PISANGKEJU_CSVTOJSON_FILE", __FILE__);
//plugin directory
define("PISANGKEJU_CSVTOJSON_DIR", dirname(PISANGKEJU_CSVTOJSON_FILE));
//plugin url
define("PISANGKEJU_CSVTOJSON_URL", plugins_url("", PISANGKEJU_CSVTOJSON_FILE));

add_action("admin_menu", "pisangkeju_csvtojson_settings_page");

function pisangkeju_csvtojson_settings_page() {
    add_menu_page(
        'CSV to JSON Converter',
        'CSV to JSON',
        'manage_options',
        'csv-to-json',
        'pisangkeju_csvtojson_settings_page_html',
        'dashicons-upload',
        6,
    );
};

$globalTableData = [[]];

function pisangkeju_csvtojson_settings_page_html() {
    global $globalTableData;
    global $globalJSONData;
    ?>
    <style>
        table,tr, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }
    </style>
    <div class="wrap">
        <h1>Convert CSV to JSON</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv">
            <input type="submit" name="convert_csv" value="Convert">
        </form>

        <button onclick="copyJSON()">Copy Rules ke Clipboard</button>
        <table>
            <tr>
                <td>Produk</td>
                <td>SKU</td>
                <td>Harga Reseller</td>
                <td>Harga Distributor</td>
            </tr>
            <?php
                foreach ($globalTableData as $rows) {
                    echo '<tr>';
                    foreach ($rows as $index => $cols) {
                        if ($index < 2) {
                            echo '<td>'. $cols .'</td>';
                        } else {
                            echo '<td>Rp'. number_format(intval($cols), 2, '.', ',') .'</td>';
                        }
                    }
                    echo '</tr>';
                }
            ?>
        </table>

        <p style="display: none;" id="jsonData"><?php echo $globalJSONData ?></p>

        <script>
            function copyJSON() {
                const jsonData = document.getElementById('jsonData').textContent;
                navigator.clipboard.writeText(jsonData).then(() => {
                    console.log('JSON copied to clipboard')
                })
                .catch(err => {
                    console.error('Faield to copy JSON', err)
                })
            }
        </script>
    </div>
    <?php
};

function csvToArray($file, $delimiter) {
    $csvData = [];
    $file = fopen($file, 'r');

    if ($file == false) {
        return 'error';
    }

    while (($line = fgetcsv($file, null, $delimiter ?? ';')) !== false) {
        $csvData[] = $line;
    }

    fclose($file);

    array_shift($csvData);

    return $csvData;
}

function arrayToJSON($arr)
{
    return [
        "type" => "single_item",
        "rule_type" => "common",
        "filters" => [
            [
                "qty" =>  1,
                "type" => "product_sku",
                "method" => "in_list",
                "value" => [$arr[1]],
                "product_exclude" => [
                    "on_wc_sale" => "",
                    "already_affected" => "",
                    "backorder" => "",
                    "values" => [],
                ],
            ],
        ],
        "title" => $arr[0],
        "priority" => "",
        "enabled" => "on",
        "sortable_blocks_priority" => ["roles", "bulk-adjustments"],
        "additional" => [
            "conditions_relationship" => "and",
            "blocks" => [
                "productFilters" => ["isOpen" => "1"],
                "productDiscounts" => ["isOpen" => "0"],
                "roleDiscounts" => ["isOpen" => "1"],
                "bulkDiscounts" => ["isOpen" => "0"],
                "freeProducts" => ["isOpen" => "0"],
                "autoAddToCart" => ["isOpen" => "0"],
                "advertising" => ["isOpen" => "0"],
                "cartAdjustments" => ["isOpen" => "0"],
                "conditions" => ["isOpen" => "0"],
                "limits" => ["isOpen" => "0"],
            ],
            "replace_name" => "",
            "is_replace_free_products_with_discount" => "",
            "free_products_replace_name" => "",
            "is_replace_auto_add_products_with_discount" => "",
            "auto_add_products_replace_name" => "",
            "sortable_apply_mode" => "consistently",
            "auto_add_cant_be_removed_from_cart" => false,
            "auto_add_show_as_recommended_product" => false,
        ],
        "conditions" => [],
        "cart_adjustments" => [],
        "limits" => [],
        "role_discounts" => [
            "rows" => [
                [
                    "discount_type" => "price__fixed",
                    "discount_value" => $arr[2],
                    "roles" => ["reseller"],
                ],
                [
                    "discount_type" => "price__fixed",
                    "discount_value" => $arr[3],
                    "roles" => ["distributor"],
                ],
            ],
        ],
        "get_products" => [
            "repeat" => "-1",
            "repeat_subtotal" => "",
            "max_amount_for_gifts" => null,
        ],
        "auto_add_products" => [
            "repeat" => "-1",
            "repeat_subtotal" => "",
        ],
        "options" => [
            "apply_to" => "expensive",
            "repeat" => -1,
        ],
        "advertising" => [
            "discount_message" => "",
            "discount_message_cart_item" => "",
            "long_discount_message" => "",
            "sale_badge" => "",
        ],
        "version" => "4.6.1",
    ];
}

if (isset($_FILES['csv_file']) && isset($_POST['convert_csv'])) {
    if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        global $globalTableData;
        global $globalJSONData;

        $tmpFile = $_FILES['csv_file']['tmp_name'];

        $tableData = csvToArray($tmpFile, ';');
        $jsonData = array_map('arrayToJSON', $tableData);
        $jsonString = json_encode($jsonData);
        
        $globalTableData = $tableData;
        $globalJSONData = $jsonString;
    } else {
        echo 'Error something something';
    }
}
