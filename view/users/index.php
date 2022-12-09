<?php include(PathList::GetPath(PathList::FILE_PATH_VIEW).'header.php'); ?>
<style>
    label, #error{
        color: white;
    }
</style>
<div id="content" class="app-content">

    <input type="text" id="mydate" gldp-id="mydate" />
    <div gldp-el="mydate"
         style="width:400px; height:300px; position:absolute; top:20px; left:50px;">
    </div>

</div>

<script type="text/javascript">
    $(function ()
    {
        apiLoad();

        function apiLoad()
        {
            $.post( "api/LoadData",
                {}, function(data)
                {
                    var array = JSON.parse(data);
                    console.log(array);

                    var val = [];
                    for (let i = 0; i < array.length; i++)
                    {
                       var value = array[i].split(',');
                        val[i] =
                              {
                                  date: new Date(value[0],value[1],value[2])
                              };
                    }
                     DatePicker(val);
                });
        };
        function DatePicker(data)
        {
            //выбераем сегодня дата
            var dateNow = new Date().toISOString().slice(0, 10);
            var parts =dateNow.split('-'); //парсим на три части

            //дата через месяц
            var date = new Date();
            var DateMonth = new Date(date.setMonth(date.getMonth()+1)).toISOString().slice(0, 10);
            var partsDateMonth =DateMonth.split('-'); //парсим на три части


            $('input').glDatePicker(
                {
                    showAlways: true,
                    allowMonthSelect: true,
                    allowYearSelect: false,
                    prevArrow: '',
                    nextArrow: '',
                    selectedDate: new Date(parts[0], parts[1], parts[2]),
                    selectableDates: data,
                });
        }
    });
</script>

<?php include(PathList::GetPath(PathList::FILE_PATH_VIEW).'footer.php'); ?>