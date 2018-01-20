$("body").on("click", "#form-with-buttons .delete-button", function(e){
    e.preventDefault();
    var id_task = this.id.split("-")[1];
    var my_data = "recordToDelete=" + id_task;
    $.ajax({
        type: "POST",
        url: "query_engine.php",
        dataType: "text",
        data: my_data,
        success: function(response){
            $('.task-' + id_task).fadeOut('slow');
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(thrownError);
        }
    });
});