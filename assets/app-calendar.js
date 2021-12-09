
 var direction = 'ltr',
  assetPath = 'assets/';


$(document).on('click', '.fc-sidebarToggle-button', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').addClass('show');
});

$(document).on('click', '.body-content-overlay', function (e) {
  $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
});



document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar'),
    eventToUpdate,
    sidebar = $('.event-sidebar'),
    calendarsColor = {
      Business: 'primary',
      Personal: 'danger',
      ETC: 'info'
    },
    eventForm = $('.event-form'),
    addEventBtn = $('.add-event-btn'),
    cancelBtn = $('.btn-cancel'),
    updateEventBtn = $('.update-event-btn'),
    toggleSidebarBtn = $('.btn-toggle-sidebar'),
    eventTitle = $('#title'),
    eventLabel = $('#select-label'),
    startDate = $('#start-date'),
    endDate = $('#end-date'),
    eventUrl = $('#event-url'),
    eventGuests = $('#event-guests'),
    eventLocation = $('#event-location'),
    allDaySwitch = $('.allDay-switch'),
    selectAll = $('.select-all'),
    calEventFilter = $('.calendar-events-filter'),
    filterInput = $('.input-filter'),
    btnDeleteEvent = $('.btn-delete-event'),
    calendarEditor = $('#event-description-editor');



  // FullCalendar Plugin
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    editable: true,
    dragScroll: true,
    dayMaxEvents: 2,
    eventResizableFromStart: true,
    selectable:true,
    customButtons: {
      sidebarToggle: {
        text: 'Sidebar'
      }
    },
    headerToolbar: {
      start: 'sidebarToggle, prev,next, title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    }, 

  


    // fetch event from DB
     events: {
       url: 'fetch.php',
       type: 'GET',


       success : function(result) {
        console.log(result);

     

         var calendars = selectedCalendars();

         return selectedEvents = result.filter(function (event) {
          // console.log(event.extendedProps.calendar.toLowerCase());
          return calendars.includes(event.extendedProps.calendar.toLowerCase());
        });
        
       
       },
       error: function(error){
         console.log(error);
       }
    },
  
  

    direction: direction,
    initialDate: new Date(),
    navLinks: true, 
    eventClassNames: function ({ event: calendarEvent }) {
      const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];

      return [
        // Background Color
        'bg-light-' + colorName
      ];
    },
    
    
    eventDrop: function(info){
      
      
      var id = info.event.id;
      var title= info.event.title;
      var start= moment(info.event.start).format('YYYY-MM-DD hh:mm');
      var end= moment(info.event.end).format('YYYY-MM-DD hh:mm') 
      var url= eventUrl.val();
      var guests = eventGuests.val();
      console.log({ guests });
      var location = eventLocation.val();
      var label= eventLabel.val();
      var description = calendarEditor.val();
      var allDay = allDaySwitch.prop('checked') ? true : false;

      $.ajax({
        url: "update.php",
        type:"POST",
        dataType: 'json',
        data: {
          key: 1,
          id: id,
          title: title,
          label: label,
          start: start,
          end: end,
          allDay: allDay,
          url: url,
          guests: guests,
          location: location,
          description: description  
        },
        success: function(data){
            alert(data);
            calendar.refetchEvents(data);
        }
      });
    },


    dateClick: function (info) {
      var date = moment(info.date).format('YYYY-MM-DD');
          resetValues();
      sidebar.modal('show');
      addEventBtn.removeClass('d-none');
      updateEventBtn.addClass('d-none');
      btnDeleteEvent.addClass('d-none');
      startDate.val(date);
      endDate.val(date);
    },
    eventClick: function (info) {
      eventClick(info);
    },
    datesSet: function () {
      modifyToggler();
    },
    viewDidMount: function () {
      modifyToggler();
    },


  
  
  });

  // Render calendar
  calendar.render();
  // Modify sidebar toggler
  modifyToggler();




// add event on click
$(addEventBtn).on('click', function () {
    if (eventForm.valid()) {
      
        var title = eventTitle.val();
        var start = moment(startDate.val()).format('YYYY-MM-DD HH:mm');
        var end = moment(endDate.val()).format('YYYY-MM-DD HH:mm');
        var guests = eventGuests.val();
        console.log({ guests });
        var location= eventLocation.val();
        var label = eventLabel.val();
        var description=calendarEditor.val();
        var url = eventUrl.val();

        var allDay = allDaySwitch.prop('checked') ? true : false;
      
      
      $.ajax({
        url: "add.php",
        type:"POST",
        data: {
          key: 1,
          title: title,
          label: label,
          start: start,
          end: end,
          allDay: allDay,
          url: url,
          guests: guests,
          location: location,
          description: description  
        },
        success: function(data){
          calendar.refetchEvents();
          alert("added Successfully");
          window.location.replace("calendar.php");
        },
        error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
        }
      })

    }

    
    
  });


// Update new event
updateEventBtn.on('click', function () {
  if (eventForm.valid()) {
    
      var id=  eventToUpdate.id;
      var title= sidebar.find(eventTitle).val();
      var start= sidebar.find(startDate).val();
      var end= sidebar.find(endDate).val();
      var url = eventUrl.val();
      var guests = eventGuests.val();
      console.log({ guests });
      var location = eventLocation.val();
      var label= eventLabel.val();
      var description = calendarEditor.val();
      var allDay = allDaySwitch.prop('checked') ? true : false;

      $.ajax({
        url: "update.php",
        type:"POST",
        data: {
          key: 1,
          id: id,
          title: title,
          label: label,
          start: start,
          end: end,
          allDay: allDay,
          url: url,
          guests: guests,
          location: location,
          description: description        
        },
        success: function(data){
            alert('event update');
            calendar.refetchEvents();
        }
      }),
      
      
      sidebar.modal('hide');
  }
});


 
  



 






// ................................................ ................................................ ................................................  ................................................ ................................................

// on add a new item, clear sidebar
    $('.add-event button').on('click', function (e) {
      $('.event-sidebar').addClass('show');
      $('.sidebar-left').removeClass('show');
      $('.app-calendar .body-content-overlay').addClass('show');
    });

 

  // Label  select
  if (eventLabel.length) {
    function renderBullets(option) {
      if (!option.id) {
        return option.text;
      }
      var $bullet =
        "<span class='bullet bullet-" +
        $(option.element).data('label') +
        " bullet-sm me-50'> " +
        '</span>' +
        option.text;

      return $bullet;
    }
    eventLabel.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select value',
      dropdownParent: eventLabel.parent(),
      templateResult: renderBullets,
      templateSelection: renderBullets,
      minimumResultsForSearch: -1,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // Start date picker
  if (startDate.length) {
    var start = startDate.flatpickr({
      enableTime: true,
      altFormat: 'Y-m-dTH:i:S',
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // End date picker
  if (endDate.length) {
    var end = endDate.flatpickr({
      enableTime: true,
      altFormat: 'Y-m-dTH:i:S',
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  

  // Modify sidebar toggler
  function modifyToggler() {
    $('.fc-sidebarToggle-button')
      .empty()
      .append(feather.icons['menu'].toSvg({ class: 'ficon' }));
  }

  // Selected Checkboxes under filter
  function selectedCalendars() {
    var selected = [];
    $('.calendar-events-filter input:checked').each(function () {
      selected.push($(this).attr('data-value'));
    });
    return selected;
  }




// ................................................
// Function for when click an event on the calendar
  function eventClick(info) {
    eventToUpdate = info.event;

    // if there is an url for an event, open it in a new window
    if (eventToUpdate.url) {
      info.jsEvent.preventDefault();
      window.open(eventToUpdate.url, '_blank');
    }


    // display the sidebar for update
    sidebar.modal('show');
    addEventBtn.addClass('d-none');
    cancelBtn.addClass('d-none');
    updateEventBtn.removeClass('d-none');
    btnDeleteEvent.removeClass('d-none');

    eventTitle.val(eventToUpdate.title);

    start.setDate(eventToUpdate.start, true, 'Y-m-d');

    eventToUpdate.allDay === true ? allDaySwitch.prop('checked', true) : allDaySwitch.prop('checked', false);

    eventToUpdate.end !== null
      ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
      : end.setDate(eventToUpdate.start, true, 'Y-m-d');
    sidebar.find(eventLabel).val(eventToUpdate.extendedProps.calendar).trigger('change');

  
    console.log(eventToUpdate.extendedProps.guests);
    eventToUpdate.extendedProps.guests !== undefined ? eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change') : null;
    
    eventToUpdate.extendedProps.location !== undefined ? eventLocation.val(eventToUpdate.extendedProps.location) : null;

    eventToUpdate.extendedProps.description !== undefined
      ? calendarEditor.val(eventToUpdate.extendedProps.description)
      : null;



    //  Delete an event, add ajax call !!!!!!
    btnDeleteEvent.on('click', function () {
      var id = eventToUpdate.id;
      $.ajax({
        url:'delete.php',
        type:'POST',
        data: {
          id: id
        },
        success: function(){
          calendar.refetchEvents();
          
        }
      })

      sidebar.modal('hide');
      $('.event-sidebar').removeClass('show');
      $('.app-calendar .body-content-overlay').removeClass('show');
    });
  }
// Validate add new and update form
  if (eventForm.length) {
    eventForm.validate({
      submitHandler: function (form, event) {
        event.preventDefault();
        if (eventForm.valid()) {
          sidebar.modal('hide');
        }
      },
      title: {
        required: true
      },
      rules: {
        'start-date': { required: true },
        'end-date': { required: true }
      },
      messages: {
        'start-date': { required: 'Start Date is required' },
        'end-date': { required: 'End Date is required' }
      }
    });
  }



  // Sidebar Toggle Btn
  if (toggleSidebarBtn.length) {
    toggleSidebarBtn.on('click', function () {
      cancelBtn.removeClass('d-none');
    });
  }

 // Reset sidebar input values
 function resetValues() {
  endDate.val('');
  eventUrl.val('');
  startDate.val('');
  eventTitle.val('');
  eventLocation.val('');
  allDaySwitch.prop('checked', false);
  eventGuests.val('').trigger('change');
  calendarEditor.val('');
}



 // When modal hides reset input values
 sidebar.on('hidden.bs.modal', function () {
  resetValues();
});

 // Hide left sidebar if the right sidebar is open
 $('.btn-toggle-sidebar').on('click', function () {
  btnDeleteEvent.addClass('d-none');
  updateEventBtn.addClass('d-none');
  addEventBtn.removeClass('d-none');
  $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
});






  // Select all & filter functionality
  if (selectAll.length) {
    selectAll.on('change', function () {
      var $this = $(this);

      if ($this.prop('checked')) {
        calEventFilter.find('input').prop('checked', true);
      } else {
        calEventFilter.find('input').prop('checked', false);
      }
      calendar.refetchEvents();
    });
  }

  if (filterInput.length) {
    filterInput.on('change', function () {
      $('.input-filter:checked').length < calEventFilter.find('input').length
        ? selectAll.prop('checked', false)
        : selectAll.prop('checked', true);
      calendar.refetchEvents();
    });
  }




// Guests select
if (eventGuests.length) {
  function renderGuestAvatar(option) {
   return option.text;
  }
  
  eventGuests.wrap('<div class="position-relative"></div>').select2({
    placeholder: 'Select guests',
    dropdownParent: eventGuests.parent(),
    closeOnSelect: false,
    templateResult: renderGuestAvatar,
    templateSelection: renderGuestAvatar,
    escapeMarkup: function (es) {
      return es;
    }
  });
}
























});
