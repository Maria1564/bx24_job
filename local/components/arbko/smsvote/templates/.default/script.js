    function functTest(manager_id) {
            console.log(manager_id);
            var manager = app.managers[manager_id];
            console.log(manager);
            // $('#simpleModal').modal('hide')
            $('#manager-span').html(manager.FIO);
        }

