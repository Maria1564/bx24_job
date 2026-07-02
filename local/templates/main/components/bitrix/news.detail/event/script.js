function ServiceSetStatus(statusId,service_id) {
    //alert(statusId);
       console.log(statusId)
    doRequest("/api/service/status.php", {status: statusId,service_id:service_id}, function (data) {
        console.log()
        $('.setStatusBtns').hide();
        $('#setStatus' + statusId).show();
        $('.status-service-text').html('<span class="status-'+statusId+'">'+data.statusText+'</span>');
    });
}