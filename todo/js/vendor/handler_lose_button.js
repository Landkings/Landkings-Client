$("body").on("click", "#form-with-buttons .lose-button", function(e){
    e.preventDefault();
    var id_task = this.id.split("-")[1];
    var my_data = "LoseTask=" + id_task;
    $.ajax({
        type: "POST",
        url: "query_engine.php",
        dataType: "text",
        data: my_data,
        success: function(response){
            $('.task-' + id_task).removeClass('success-task');
            $('.task-' + id_task).removeClass('lose-task');
            $('.task-' + id_task).addClass('lose-task');
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(thrownError);
        }
    });
});