<html>
<body>
	<header>
        <img class="logo" src="{{asset('img/logo.jpg')}}" width="100px" height="100px" />
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
            CERTIFICACIÓN DE BAUTISMO
        </h3>
        <br/>
        <span style="font-size: 17px;">El infrascrito Párroco de la Parroquia Santa Cruz, por las presentes letras.</span>
        <br/>
        <h4>CERTIFICA</h4>
    </div>

    <div class="text-body">
        <p>
        Que el Libro de Bautizmo Número <b>{{$bautizo->libro->no_libro}}</b> en el Folio Número <b>{{$bautizo->folio}}</b> Se encuentra el Acta que literalmente dice:
        <br />
        En chiquimulilla el {{$bautizo->fecha}} <br/>
        Bauticé solemntemente a 
       <b> {{$bautizo->bautizado->primer_nombre}} {{$bautizo->bautizado->segundo_nombre}} {{$bautizo->bautizado->primer_apellido}} {{$bautizo->bautizado->segundo_apellido}}</b> <br />
        Que nació el {{$bautizo->bautizado->fecha_nac}} <br />
        Hijo(a) de 
        <b>{{$bautizo->padre->primer_nombre}} {{$bautizo->padre->segundo_nombre}} {{$bautizo->padre->primer_apellido}} {{$bautizo->padre->segundo_apellido}}
        Y 
        {{$bautizo->madre->primer_nombre}} {{$bautizo->madre->segundo_nombre}} {{$bautizo->madre->primer_apellido}} {{$bautizo->madre->segundo_apellido}}</b><br />

        Padrinos: 
        <b>{{$bautizo->padrino1->primer_nombre}} {{$bautizo->padrino1->segundo_nombre}} {{$bautizo->padrino1->primer_apellido}} {{$bautizo->padrino1->segundo_apellido}}
        Y 
        {{$bautizo->padrino2->primer_nombre}} {{$bautizo->padrino2->segundo_nombre}} {{$bautizo->padrino2->primer_apellido}} {{$bautizo->padrino2->segundo_apellido}}</b> <br />

        Al margen se lee ________________________________________________________<br />

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