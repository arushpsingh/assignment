/**
 * @file
 * Contains JS function
 */
(function ($, window, Drupal) {
  //My custom code
  Drupal.behaviors.exampleModule = {
    attach: function (context, settings) {
      console.log("Hi");
      function getDate(tz) {
        let months = [];
        months[0] = "Jan";
        months[1] = "Feb";
        months[2] = "Mar";
        months[3] = "Apr";
        months[4] = "May";
        months[5] = "Jun";
        months[6] = "July";
        months[7] = "Aug";
        months[8] = "Sep";
        months[9] = "Oct";
        months[10] = "Nov";
        months[11] = "Dec";
        let today_tz = new Date().toLocaleString("en-US", { timeZone: tz });
        let today_obj = new Date(today_tz);
        let today_date = today_obj.getDate();
        let today_month = months[today_obj.getMonth()];
        let today_year = today_obj.getFullYear();
        let time = today_obj.toLocaleTimeString();
        return (
          today_date + "th" + today_month + "th" + today_year + "th" + time
        );
      }
      function disp_tz(tz) {
        let getId = tz.split("/");
        let date_with_format = getDate(tz);
        document.getElementById(getId[1]).innerHTML =
          date_with_format + "," + tz + "<br>";
        display_c(tz);
      }
      function display_c(tz) {
        var refresh = 1000;
        mytime = settimeout(disp_tz, refresh, tz);
      }

      let data = settings.timezone;
      for (let i in data) {
        disp_tz(data[i]);
      }
    },
  };
})(jQuery, window, Drupal);
