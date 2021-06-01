$(()=>{
    $('#home-page').addClass("active");
    $('#manage-content').load("content/list-new-order.php");

    $('#btn-new-order').click(()=>{
        $('#manage-content').load("content/list-new-order.php");
    })
    $('#btn-processed-order').click(()=>{
        $('#manage-content').load("content/list-processed-order.php");
        
    })
    $('#btn-complete-order').click(()=>{
        $('#manage-content').load("content/list-complete-order.php");
        
    })
    $('#btn-view-sales').click(()=>{
        $('#manage-content').load("content/view-sales.php");
        
    })
    $('#btn-add-product').click(()=>{
        $('#manage-content').load("content/add-new-product.php");
    })
    $('#btn-manage-user').click(()=>{
        $('#manage-content').load("content/table-user.php");
    })
    $('#btn-manage-product').click(()=>{
        $('#manage-content').load("content/manage-product.php");
    })
})

var process_payment_id = null;
function confirmbox_processShipment(id) {
    process_payment_id = id;
    $("#confirm-process-shipment-popup").modal("open");
}
function processShipment() {
    // execute php file -- process shipment;
    $.post("content/process-shipment.php", {
        payment_id: process_payment_id
    },
    (data,status) => {
        /* alert(data); */
        if(data == 'success'){
            $('#manage-content').load("content/list-new-order.php");
            $("#confirm-process-shipment-popup").modal("close");
            /* $("#success-shipment-update-popup").modal("open"); */
            $("#text-popup").html("Successfully Updated");
            $("#success-popup").modal("open");
            setTimeout(()=> {
                $("#success-popup").modal("close");
            },2000)
        }
    }
    )
}

var del_user_id = null;
function confirmbox_deleteUser(id){
    del_user_id = id;
    $("#confirm-delete-popup").modal("open");
}
function deleteUser(){
    // execute php file -- delete user;
    $.post("content/delete-user.php", {
        user_id: del_user_id
    },
    (data,status) => {
        if(data == 'deleted'){
            $('#manage-content').load("content/table-user.php");
            $('#total-user-board').html(parseInt($('#total-user-board').html()) - 1);
            $("#confirm-delete-popup").modal("close");
            /* $("#success-delete-popup").modal("open"); */
            $("#text-popup").html("Successfully Deleted");
            $("#success-popup").modal("open");
            setTimeout(()=> {
                $("#success-popup").modal("close");
            },2000)
        }
    }
    )
}

function add_product(obj) {
    event.preventDefault();
    var product_form = new FormData(obj);
    $.ajax({
        method: "post",
        contentType: false,
        processData: false,
        cache: false,
        url: "content/add-product-db.php",
        data: product_form,
        enctype: "multipart/form-data",
        success: (data) => {
            if(data == 'successfully added'){
                $('#manage-content').load("content/add-new-product.php");
                $('#total-product-board').html(parseInt($('#total-product-board').html()) + 1);
                $("#text-popup").html("Product Added");
                $("#success-popup").modal("open");
                setTimeout(()=> {
                    $("#success-popup").modal("close");
                },2000)
            }
        }
    })
}

function changeAvailability(product_id) {
    $.post("content/change-availability.php", {
        product_id: product_id
    },
    (data,status) => {
        if(data == "changed") {
            $('#manage-content').load("content/manage-product.php");
        }
    })
}