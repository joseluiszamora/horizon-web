<link href='<?php echo base_url(); ?>css/calendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>css/calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo base_url(); ?>js/calendar/moment.min.js'></script>
<script src='<?php echo base_url(); ?>js/calendar/fullcalendar.min.js'></script>

<script>
  //var url = "http://localhost/horizon/index.php/";
  var url = "https://mariani.bo/horizon-sc/index.php/";
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      defaultDate: '2014-08-12',
      editable: true,
      events: {
        url: url + 'routes/get_calendar',
        error: function() {
          $('#script-warning').show();
        }
      },
      loading: function(bool) {
        $('#loading').toggle(bool);
      }
    });

  });

</script>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }
  #loading {
    display: none;
    position: absolute;
    top: 10px;
    right: 10px;
  }
  #calendar {
    width: 900px;
    margin: 40px auto;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="tab-content">
      <div id="home" class="row tab-pane active">
        <div id='calendar'></div>
      </div>
    </div>
  </div>
</div>