$(document).ready(function(){
    // Requisição AJAX para inserir QR code
    $("#submitBtn").click(function(){
        var data = $("#data").val();
        $.post("insert_qrcode.php", {data: data}, function(response){
            alert(response);
            loadQRCodes(); // Recarrega os QR codes após a inserção
        });
    });

    // Requisição AJAX para excluir QR code
    $(document).on("click", ".deleteBtn", function(){
        var id = $(this).data('id');
        $.post("delete_qrcode.php", {id: id}, function(response){
            alert(response);
            loadQRCodes(); // Recarrega os QR codes após a exclusão
        });
    });

    // Função para carregar os QR codes
    function loadQRCodes() {
        $.get("get_qrcodes.php", function(data){
            $("#qrcodes").html(data);
        });
    }

    // Carrega os QR codes quando a página é carregada
    loadQRCodes();
});
