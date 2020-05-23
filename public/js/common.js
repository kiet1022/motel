$('[data-toggle="tooltip"]').tooltip();

/**
* Block client UI
* 
* @param status true or false 
*/
function blockUI(status){
  if(status){
    $.blockUI({ message: '<div class="spinner-grow text-primary" style="width: 3rem; height: 3rem; z-index: 1" role="status"><span class="sr-only">Loading...</span></div>', 
    css: {backgroundColor: 'transparent',border: 'none'} });
  } else {
    $.unblockUI();
  }
}

/**
* 
* @param {string} status success, error, warning
* @param {string} message The message being show
*/
function showNotify(status, message){
  var title = '';
  var type = '';
  if(status === "success"){
    title = '<h4><i class="fas fa-check-circle"></i> Success!!!</h4>';
    type = 'success';
  } else if(status === "error"){
    title = '<h4><i class="fas fa-times-circle"></i> Error!!!</h4>';
    type = 'danger';
  } else if (status === "warning") {
    title = '<h4><i class="fas fa-exclamation-circle"></i> Warning!!!</h4>';
    type = 'warning';
    
  }
  
  // handle show notify
  $.notify({
    // options
    title: title,
    message: message,
  },{
    // settings
    type: type,
    newest_on_top: true,
    offset: {
      x: 20,
      y: 20
    },
    spacing: 10,
    z_index: 1031,
    delay: 4000,
    timer: 500,
    animate: {
      enter: 'animated flipInY',
      exit: 'animated flipOutX'
    },
    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    '<span data-notify="icon"></span> ' +
    '<span data-notify="title">{1}</span> ' +
    '<span data-notify="message">{2}</span>' +
    '<div class="progress" data-notify="progressbar">' +
    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    '</div>' +
    '<a href="{3}" target="{4}" data-notify="url"></a>' +
    '</div>' 
  });
}

/**
* Showing warning message
* 
* @param {String} message The message that showed in dialog
*/
function showWarning(message){
  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_DEFAULT,
    title: 'Chú ý! ',
    message: message,
    buttons: [{
      label: 'OK',
      cssClass: 'btn-primary btn-sm',
      action: function(dialogRef){
        dialogRef.close();
      }
    }]
  });    
}

/**
* Get current date
* 
*/
function getCurrentDate(){
  var today = new Date();
  var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  return date;
}

/**
* Get current time
* 
*/
function getCurrentTime(){
  var today = new Date();
  var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  return time;
}

/**
* Get current datetime
*/
function getCurrentDateTime(){
  var dateTime = getCurrentDate()+' '+getCurrentTime();
  return dateTime;
}

/**
 * Format number to currency
 * 
 * @param {Integer} number the number that will be formated
 */
function numberFormat(number){
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}