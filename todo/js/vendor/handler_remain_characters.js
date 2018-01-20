$('body').on("keyup input", "#title", function(e){
    var strlen = this.value.length;
    if (strlen >= 100){
        var input_text = this.value.substr(0, 100);
        this.value = input_text;
        strlen = this.value.length;
    }
    $('#title-label').text("Название задачи (осталось " + String(100 - strlen) + " символов)");
});

$('body').on("keyup input", "#description", function(e){
    var strlen = this.value.length;
    if (strlen >= 255){
        var input_text = this.value.substr(0, 255);
        this.value = input_text;
        strlen = this.value.length;
    }
    $('#description-label').text("Краткое описание задачи (осталось " + String(255 - strlen) + " символов)");
});