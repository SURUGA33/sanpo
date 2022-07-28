<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanpo Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<link href="{{asset('/css/sanpo.css')}}" rel="stylesheet">
<script src="{{ asset('/js/sanpo.js') }}"></script>
  </head>
  <body>
    <input
      id="pac-input"
      class="controls"
      type="text"
      placeholder="Search Box"
    />
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdMfA0kydGyZo6BY42hHW5KFkLNl95Uf0&callback=initAutocomplete&libraries=places&v=weekly"
      async>
    </script>
  </body>
</html>