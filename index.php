<?php
require_once(__DIR__ . "/vendor/autoload.php");

// Configure API key authorization: api_key
Introvert\Configuration::getDefaultConfiguration()->setHost('https://api.s1.yadrocrm.ru/tmp');


foreach (getClients() as $value)
{
    $price =  LeadGetAll($value['api']);

    $array[] = [
        'ID'=>$value['id'],
        'Name'=>$value['name'],
        'Price'=> $price,
    ];
    $sum = $price + $sum;

}

echo ('Дата от: '.date('Y-m-d H:i:s', ($_GET["date_from"])).'; Дата до: '.date('Y-m-d H:i:s', ($_GET["date_to"])));


function LeadGetAll($key = '', $offset = 0)
{
    Introvert\Configuration::getDefaultConfiguration()->setApiKey('key', $key);

    $api = new Introvert\ApiClient();

    // определяем длину массива
    $array_count = 5000;

    $status = array(142); // int[] | фильтр по id статуса
    $count = 100; // int | Количество запрашиваемых элементов

    $date_from = intval($_GET["date_from"]);
    $date_to = intval($_GET["date_to"]);

    $price = 0;
    $i=0;
    try {
        // сам поиск
        for ($i=0; $i<$array_count; $i = ($i+$count))
        {
            $offset = $i;
            $result = $api->lead->getAll(NULL, $status, NULL, NULL, $count, $offset);
            foreach ($result['result'] as $value)
            {
                if ($date_from < $value['date_close'] and $date_to > $value['date_close'] )
                {
                    $price = intval($value['price'])+$price;
                }
            }

            if (count($result['result']) == 0)
            {
                break;
            }

            //var_dump(count($result['result']));
        }
        return $price;

    } catch (Exception $e) {
        return 0;
    }

}

function getClients() {
        return [
            [
                'id' => 1,
                'name' => 'intrdev',
                'api' => '23bc075b710da43f0ffb50ff9e889aed'
            ],
        ];
    }

?>


    <table>
        <tr>
            <th>ID клиента</th>
            <th>Название клиента</th>
            <th>Сумма успешных сделок</th>
        </tr>
        <?php foreach ($array as $value) { ?>
        <tr>
            <td><?php echo($value['ID']);?></td>
            <td><?php echo($value['Name']);?></td>
            <td><?php echo($value['Price']);?></td>
        </tr>
        <?php }; ?>
    </table>

    <p> Общая сумма: <?php echo($sum);?></p>




