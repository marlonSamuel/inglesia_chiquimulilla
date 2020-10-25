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
            CERTIFICACIÓN DE MATRIMONIO
        </h3>
        <br/>
        <span style="font-size: 17px;">El infrascrito Párroco de la Parroquia Santa Cruz, por las presentes letras.</span>
        <br/>
        <h4>CERTIFICA</h4>
    </div>

    <div class="text-body">
        <p>
        Que el Libro de Matrimonios Número <b>{{$matrimonio->libro->no_libro}}</b> en el Folio Número <b>{{$matrimonio->folio}}</b> Se encuentra el Acta que literalmente dice:
        <br />

        En la iglesia <b>{{$matrimonio->parroco_parroquia->parroquia->nombre}}</b> En chiquimulilla el {{$matrimonio->fecha}} <br/>

        Previos los tramites de Derecho y no habiendo impedimento canónico presencié y bendije en presencia de los testigos <b>{{$matrimonio->testigos}}</b><br/>

        El matrimonio de don
       <b> {{$matrimonio->novio->primer_nombre}} {{$matrimonio->novio->segundo_nombre}} {{$matrimonio->novio->primer_apellido}} {{$matrimonio->novio->segundo_apellido}}</b> <br />
       Originario de: {{$matrimonio->novio->direccion}} {{$matrimonio->novio->municipio->nombre}}
                      {{$matrimonio->novio->municipio->departamento->nombre}}
        de {{$age_novio}} años de edad feligrés de {{$matrimonio->parroquia_novio->nombre}}<br/>

        Hijo de :
        <b>{{$matrimonio->padre_novio->primer_nombre}} {{$matrimonio->padre_novio->segundo_nombre}} {{$matrimonio->padre_novio->primer_apellido}} {{$matrimonio->padre_novio->segundo_apellido}}
        Y 
        {{$matrimonio->madre_novio->primer_nombre}} {{$matrimonio->madre_novio->segundo_nombre}} {{$matrimonio->madre_novio->primer_apellido}} {{$matrimonio->madre_novio->segundo_apellido}}</b><br />

        Con la Señora
       <b> {{$matrimonio->novia->primer_nombre}} {{$matrimonio->novia->segundo_nombre}} {{$matrimonio->novia->primer_apellido}} {{$matrimonio->novia->segundo_apellido}}</b> <br />
       Originaria de: {{$matrimonio->novia->direccion}} {{$matrimonio->novia->municipio->nombre}}
                      {{$matrimonio->novia->municipio->departamento->nombre}}
        de {{$age_novia}} años de edad feligrés de {{$matrimonio->parroquia_novia->nombre}}<br/>

        Hijo de 
        <b>{{$matrimonio->padre_novia->primer_nombre}} {{$matrimonio->padre_novia->segundo_nombre}} {{$matrimonio->padre_novia->primer_apellido}} {{$matrimonio->padre_novia->segundo_apellido}}
        Y 
        {{$matrimonio->madre_novia->primer_nombre}} {{$matrimonio->madre_novia->segundo_nombre}} {{$matrimonio->madre_novia->primer_apellido}} {{$matrimonio->madre_novia->segundo_apellido}}</b><br />

        Firma el acta el padre: <b> {{$matrimonio->parroco_parroquia->parroco->primer_nombre}} 
                                {{$matrimonio->parroco_parroquia->parroco->segundo_nombre}}
                                {{$matrimonio->parroco_parroquia->parroco->primer_apellido}}
                                {{$matrimonio->parroco_parroquia->parroco->segundo_apellido}}
                                </b><br />

        Al margen se lee:  <b> {{$matrimonio->novio->primer_nombre}} {{$matrimonio->novio->segundo_nombre}} {{$matrimonio->novio->primer_apellido}} {{$matrimonio->novio->segundo_apellido}}
        Y
        {{$matrimonio->novia->primer_nombre}} {{$matrimonio->novia->segundo_nombre}} {{$matrimonio->novia->primer_apellido}} {{$matrimonio->novia->segundo_apellido}}</b><br />

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