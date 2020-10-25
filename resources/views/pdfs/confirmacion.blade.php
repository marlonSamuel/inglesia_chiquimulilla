<html>
<body>
	<header>
        <img class="logo" src="{{asset('img/logo_report.jpeg')}}" width="100px" height="100px" />
        <b>PARROQUIA SANTA CRUZ</b> <br />
        <b>Casa Parroquial</b> <br />
        <b>Chiquimulilla, Santa Rosa</b> <br />
        <b>C.P. 06008 Tel.: 7885-0193</b> <br />
        <b>Guatemala</b> <br />
    </header>
    <br />
    <br />
    <br />
    <br />
    <div class="title">
        <h3>
            CERTIFICACIÓN DE CONFIRMACION
        </h3>
        <br/>
        <span style="font-size: 17px;">El infrascrito Párroco de la Parroquia Santa Cruz, por las presentes letras.</span>
        <br/>
        <h4>CERTIFICA</h4>
    </div>

    <div class="text-body">
        <p>
        Que el Libro de Confirmación Número <b>{{$confirmacion->libro->no_libro}}</b> en el Folio Número <b>{{$confirmacion->folio}}</b> Se encuentra el Acta que literalmente dice:
        <br />
        En chiquimulilla el {{$confirmacion->fecha}} <br/>
        El Excmo. MOnseñorl {{$confirmacion->monsenior}} <br/>
        Confirió el Sacramento de la Confirmación a 
       <b> {{$confirmacion->confirmado->primer_nombre}} {{$confirmacion->confirmado->segundo_nombre}} {{$confirmacion->confirmado->primer_apellido}} {{$confirmacion->confirmado->segundo_apellido}}</b> <br />
        De {{$age}} de edad, Bautizado en la parroquia de {{$confirmacion->parroquia->nombre}}<br />
        Hijo(a) de 
        <b>{{$confirmacion->padre->primer_nombre}} {{$confirmacion->padre->segundo_nombre}} {{$confirmacion->padre->primer_apellido}} {{$confirmacion->padre->segundo_apellido}}
        Y 
        {{$confirmacion->madre->primer_nombre}} {{$confirmacion->madre->segundo_nombre}} {{$confirmacion->madre->primer_apellido}} {{$confirmacion->madre->segundo_apellido}}</b><br />

        Padrinos: 
        <b>{{$confirmacion->padrino1->primer_nombre}} {{$confirmacion->padrino1->segundo_nombre}} {{$confirmacion->padrino1->primer_apellido}} {{$confirmacion->padrino1->segundo_apellido}}
        Y 
        {{$confirmacion->padrino2->primer_nombre}} {{$confirmacion->padrino2->segundo_nombre}} {{$confirmacion->padrino2->primer_apellido}} {{$confirmacion->padrino2->segundo_apellido}}</b> <br />

        Firma el acta el padre: <b> {{$confirmacion->parroco_parroquia->parroco->primer_nombre}} 
                                {{$confirmacion->parroco_parroquia->parroco->segundo_nombre}}
                                {{$confirmacion->parroco_parroquia->parroco->primer_apellido}}
                                {{$confirmacion->parroco_parroquia->parroco->segundo_apellido}}
                                </b><br />

        Al margen se lee:  <b> {{$confirmacion->confirmado->primer_nombre}} {{$confirmacion->confirmado->segundo_nombre}} {{$confirmacion->confirmado->primer_apellido}} {{$confirmacion->confirmado->segundo_apellido}}</b><br />

            En consecuencia y para los usos que al interesado convengan, extiende, firma y sella la presente en el despacho de la Parroquia Santa Cruz Chiquimulilla, Depto. De Santa Rosa.

        </p>

    <br />
    <br />
    <br />
    <div style="text-align:center;">
            ___________________________________<br />
            <label style="text-align: center;">
                
                Pbro. Juan José Jiménez<br />
                PARROCO
            </label>
        </div>
    </div>
</body>
</html>


<style>
        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Extra personal styles **/
            text-align: center;
            line-height: 0.5cm;
            font-size: 14px;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .title {
            text-align: center;
            /*border: 1px solid;
            margin: 2px;
            background-color: gray;
            border-radius: 4px;*/
        }

        .logo {
            position: fixed;
            text-align: left;
            margin: 30px, 20px, 0px, 0px;
            border-radius: 50%;
        }

        .title-body {
            line-height: 1.5em;
            font-size: 12px;
            font-weight: bold;
        }

        .text-body {
            font-size: 17px;
            font-weight: normal;
            text-align: justify;
        }

        .right {
            text-align: right;
        }

        p {
            line-height: 2.5em;
            font-size: 18px;
            text-align: justify;
        }

        b {
            margin: 25px;
        }

        ol li {
            padding: 5px;
        }
    </style>