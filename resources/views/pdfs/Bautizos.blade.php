<html>
<head>
    <style>
      table {
        width:100% !important;
      }
      th {
        background-color: #C7D0E3;
        color: black;
      }
      table, th, td {

      }
      
      .logo {
            position: fixed;
            text-align: left;
            margin: 30px, 20px, 0px, 0px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
  <header>
      <img class="logo" src="{{asset('img/logo_report.jpeg')}}" width="100px" height="100px" />
      <div style="text-align: center; font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;">
            <h2> PARROQUIA SANTACRUZ CHIQUIMULILLA</h2>
        <b>Casa Parroquial</b> <br />
          <b>Chiquimulilla, Santa Rosa</b> <br />
          <b>C.P. 06008 Tel.: 7885-0193</b> <br />
          <b>Guatemala</b> <br />
      </div>

    
      <h3 style="text-align: center; font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;">REPORTE DE BAUTIZOS 
        @if ($from != 0 and $to != 0)
        <span>DEL {{date('d-m-Y', strtotime($from))}} AL {{date('d-m-Y', strtotime($to))}}</span>
        @endif
      </h3>
      <h5 style="text-align: center; font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;">Fecha {{ date('d/m/Y H:i:s') }}</h5>
        
  </header>
  <br />
  <table>
    <thead>
      <tr>
        <th>FECHA</th>
        <th>FELIGRES</th>
        <th>FECHA NACIMIENTO</th>
        <th>DIRECCION</th>
        <th>PADRES</th>
        <th>PADRINOS</th>
      </tr>
    </thead>
    <thead>
      @foreach($bautizos as $bautizo)
      <tr>
        <td>{{date('d-m-Y', strtotime($bautizo->fecha))}}</td>
        <td>{{$bautizo->nombres}}</td>
        <td>{{date('d-m-Y', strtotime($bautizo->bautizado->fecha_nac))}}</td>
        <td>{{$bautizo->direccion}}</td>
        <td>{{$bautizo->padres}}</td>
        <td>{{$bautizo->padrinos}}</td>
      </tr>
      @endforeach
    </thead>
  </table>
</body>
</html>
