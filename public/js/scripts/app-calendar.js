/* Calendar */
/*-------- */

$(document).ready(function () {
  /* initialize the calendar
   -----------------------------------------------------------------*/
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;
  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('fc-external-drag');
  var checkbox = document.getElementById('drop-remove');
  var currentDate = new Date();
  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1;
  var year = currentDate.getFullYear();
  var today = year+'-'+(month<9 ? '0'+month:month)+'-'+(day<9 ? '0'+day:day);
  
  //  Basic Calendar Initialize
  var basicCal = document.getElementById('basic-calendar');
  var fcCalendar = new FullCalendar.Calendar(basicCal, {
    defaultDate: '2021-08-06',
    editable: true,
    plugins: ["dayGrid", "interaction"],
    eventLimit: true, // allow "more" link when too many events
    events: [
      {
        title: 'All Day Event',
        start: '2021-08-06'
      },
      {
        title: 'Long Event',
        start: '2021-08-07',
        end: '2021-08-07'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2021-08-07T16:00:00'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2021-08-04T16:00:00'
      },
      {
        title: 'Conference',
        start: '2021-08-12',
        end: '2021-08-12'
      },
      {
        title: 'Meeting',
        start: '2021-08-15T10:30:00',
        end: '2021-08-15T12:30:00'
      },
      {
        title: 'Click for Google',
        url: 'http://google.com/',
        start: '2021-08-09'
      }
    ],
  });
  fcCalendar.render();

  // initialize the calendar
  // -----------------------------------------------------------------
  var calendar = new Calendar(calendarEl, {
    header: {
      left: 'prev,next today',
      center: 'title',
      right: ""
    },
    editable: true,
    plugins: ["dayGrid", "timeGrid"],
    droppable: false, // this allows things to be dropped onto the calendar
    defaultDate: today,
    defaultView: 'timeGridWeek',
    events: [
      {
        title: 'Session1',
        start: '2021-08-05T06:30:00',
        end: '2021-08-05T07:30:00'
      },
      {
        title: 'Session2',
        start: '2021-08-05T08:30:00',
        end: '2021-08-05T09:30:00'
      },
      {
        title: 'Availabilty',
        start: '2021-08-05T07:30:00',
        color:"#e51c23"
      },
      {
        title: 'Session1',
        start: '2021-08-06T09:30:00',
        end: '2021-08-06T11:30:00'
      },
      {
        title: 'Session2',
        start: '2021-08-06T12:30:00',
        end: '2021-08-06T14:00:00'
      },
      {
        title: 'Availabilty',
        start: '2021-08-06T11:30:00',
        color:"#e51c23"
      }],
    drop: function (info) {
      // is the "remove after drop" checkbox checked?
      if (checkbox.checked) {
        // if so, remove the element from the "Draggable Events" list
        info.draggedEl.parentNode.removeChild(info.draggedEl);
      }
    }
  });
  calendar.render();

  // initialize the external events
  // ----------------------------------------------------------------

  //   var colorData;
  $('#external-events .fc-event').each(function () {
    // Different colors for events
    $(this).css({ 'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color') });
  });
  var colorData;
  $('#external-events .fc-event').mousemove(function () {
    colorData = $(this).data('color');
  })
  // Draggable event init
  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function (eventEl) {
      return {
        title: eventEl.innerText,
        color: colorData
      };
    }
  });
})