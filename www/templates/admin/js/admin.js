/**
 * Получение данных с формы
 *
 */
function getData(obj_form) {
    var hData = {};
    $('input, textarea, select', obj_form).each(function () {
        if (this.name && this.name != '') {
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
};

/**
 * Добавление новой категории
 */

function newCategory(){
    var postData = getData('.blockNewCategory');

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/addnewcat/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if (data['success']){
                alert(data['message']);
                $('.newCategoryName').val('');
            } else {
                alert(data['message']);
            }
        }
    });
}


/**
 * Функция обновления категории
 *
 * @param itemId
 */
function updateCat(itemId){
    var parentId = $('.parentId_' + itemId).val();
    var newName = $('.itemName_' + itemId).val();
    var postData = {itemId: itemId, parentId: parentId, newName: newName};

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/updatecategory/",
        data: postData,
        dataType: 'json',
        success: function (data){
            alert(data['message']);
        }
    });
}


/**
 * Функция добавления нового продукта
 */
function addProduct(){
    var itemName = $('.newItemName').val();
    var itemPrice = $('.newItemPrice').val();
    var itemCatId = $('.newItemCatId').val();
    var itemDesc = $('.newItemDesc').val();

    var postData = {itemName: itemName, itemPrice: itemPrice, itemCatId: itemCatId, itemDesc: itemDesc};

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/addproduct/",
        data: postData,
        dataType: 'json',
        success: function (data){
            alert(data['message']);
        }
    });
}


/**
 * ИЗМЕНЕНИЕ ДАННЫХ ПРОДУКТА
 * @param itemId
 */
function updateProduct(itemId){

    var itemName = $('.itemName_'+itemId).val();
    var itemPrice = $('.itemPrice_'+itemId).val();
    var itemCatId = $('.itemCatId_'+itemId).val();
    var itemDesc = $('.itemDesc_'+itemId).val();
    var itemStatus = $('.itemStatus_'+itemId).attr('checked');

    if (! itemStatus){
        itemStatus = 1
    }else {
        itemStatus = 0
    }

    var postData = {itemId: itemId, itemName: itemName, itemPrice: itemPrice, itemCatId: itemCatId, itemDesc: itemDesc, itemStatus: itemStatus};

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/updateproduct/",
        data: postData,
        dataType: 'json',
        success: function (data){
            alert(data['message']);
        }
    });
}




/**
 * Показывать или прятать данные о заказе
 *
 */
function showProducts(id) {
    var objName = ".purchasesForOrderId_" + id;
    if ($(objName).css('display') != 'table-row') {
        $(objName).show();
    } else {
        $(objName).hide();
    }
}




function updateOrderStatus(itemId){
    var status = $('.itemStatus_' + itemId).attr('checked');
    if (!status){
        status = 0
    }else {
        status = 1
    }

    var postData = {itemId:itemId,status:status};

    $.ajax({
       type: 'POST',
       async: true,
       url: "/admin/setorderstatus/",
        data: postData,
        dataType: 'json',
        success: function (data){
           if (data['success']){
              alert(data['message']);
           }else {
               alert(data['message']);
           }
        }
    });

}


/**
 * Функция добавления даты оплаты
 *
 * @param itemId
 */
function updateDatePayment(itemId){
    var datePayment = $('.datePayment_' + itemId).val();
    var postData = {itemId:itemId,datePayment:datePayment};

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/setorderdatepayment/",
        data: postData,
        dataType: 'json',
        success: function (data){
            if (data['success']){
                alert(data['message']);
            }else {
                alert(data['message']);
            }
        }
    });
}



/**
 * Авторизация пользователя
 *
 */
function adminLogin() {
    var email = $('.adminEmail').val();
    var pwd = $('.adminPass').val();

    var postData = "adminEmail=" + email + "&adminPwd=" + pwd;

    $.ajax({
        type: 'POST',
        async: true,
        url: "/admin/adminlogin/",
        data: postData,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            if (data['success']) {
                window.location.href ="http://www.myshop.local/admin/";
            } else {
                alert(data['message']);
            }
        }
    });
}