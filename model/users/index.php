<?php

class users
{

    public function actionIndex() 
    {
      // Рендер главной страницы портала
      view::render('users','index');
    }


    public function actionLoadData()
    {
        // Configure API key authorization: api_key
        Introvert\Configuration::getDefaultConfiguration()->setHost('https://api.s1.yadrocrm.ru/tmp');
        Introvert\Configuration::getDefaultConfiguration()->setApiKey('key', "23bc075b710da43f0ffb50ff9e889aed");

        $api = new Introvert\ApiClient();


        $array_count = 50000; // общее кол-во записей для поиска
        $idcustomfields = '1522997'; //id кастомного поля
        $namecustomfields = 'gav_date';
        $status = array(45632068,41477659,41477665,142,143); // int[] | фильтр по id статуса
        $count = 100; // int | Количество запрашиваемых элементов

        $data = [];
        $array_data = [];

        try {
            // сам поиск
            for ($i=0; $i<$array_count; $i = ($i+$count))
            {
                $offset = $i;
                $result = $api->lead->getAll(NULL, $status, NULL, NULL, $count, $offset);
                foreach ($result['result'] as $value)
                {
                    foreach ($value['custom_fields'] as $custom_array)
                    {
                        if ($custom_array['id'] == $idcustomfields)
                        {
                                foreach ($custom_array['values'] as $values)
                                {
                                    $data[] = $values['value'];
                                }
                        }
                    }
                }

                if (count($result['result']) == 0)
                {
                    break;
                }
            }
        } catch (Exception $e) {
            return 0;
        }

        $ListData = $this->ListData();
        //проверяем кол-во найденых дат на повторения и считаем их
        //если кол-во меньше или равно 5 то выводим
        foreach (array_count_values($data) as $key => $count)
        {
            if ($count>5)
            {
                $key = trim(str_replace('00:00:00','',$key));
                unset($ListData[array_search($key,$ListData)]);
            }
        }
        echo (json_encode($ListData));
    }


    private function ListData()
    {
        $start = strtotime(date('Y-m-d'));
        $finish = strtotime(date('Y-m-t'));
        $p=0;
        $array = [];
        for($i = $start; $i <= $finish; $i += 86400) {
            $list = explode('.', date('Y.m.d', $i));
            $array[] = implode('-', $list);
        }
        return $array;
    }




}
