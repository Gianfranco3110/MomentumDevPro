<!DOCTYPE html>

<html>

<head>

    <title>CERTIFICADO YARE-STYLO</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        .parisienne-regular {
            font-family: "Roboto", sans-serif !important;
            font-weight: 500;
            font-style: normal;
        }
        .playfair-display {
        font-family: "Playfair Display", serif;
        font-optical-sizing: auto;
        font-weight: 500;
        font-style: italic;
        line-height: 1;
        }



    /**
    * Establecer los márgenes del PDF en 0
    * por lo que la imagen de fondo cubrirá toda la página.
    **/
    @page {
        margin: 0cm 0cm;
    }

    /**
            * Define los márgenes reales del contenido de tu PDF
            * Aquí arreglarás los márgenes del encabezado y pie de página
            * De tu imagen de fondo.
            **/
    body {
        margin-top: 3.5cm;
        margin-bottom: 1cm;
        margin-left: 2cm;
        margin-right: 2cm;
    }

    h1 {
        margin-left: 4cm;
    }

    /**
            * Defina el ancho, alto, márgenes y posición de la marca de agua.
            **/
    #watermark {
        position: fixed;
        top: 0 px;
        bottom: 0px;
        left: 0px;
        /** El ancho y la altura pueden cambiar
                    según las dimensiones de su membrete
                **/
        width: 21.8cm;
        height: 30cm;

        /** Tu marca de agua debe estar detrás de cada contenido **/
        z-index: -1000;
    }
    </style>

</head>

<body>
    <img src="{{$dataViews['url_qr']}}" style="opacity: 0.9; position: absolute; right: 30px; bottom: 30px" width="68"/>
    <div id="watermark">
        <img src="certificado-templete/cetificado.png" style="width: 795px"/>
    </div>
    {{-- <main style="padding-left: 139px; padding-right: 139px" >
        <p class="cardo-regular " style="margin-top: -4px; color: #083762; font-size: 31px">COLEGIO BORCELLE DEL ESTADO DE MÉXICO </p>
    </main> --}}

    <main style="padding-top: 10px;">
        <p class="playfair-display" style="margin-top: 390px; color: #212120; text-align: center; font-size: 67px;text-transform: capitalize; ">{{$dataViews['user']->name}} </p>
    </main>


    <main style=" padding-left: 2px; padding-right: 2px;margin-top: -40px;" >
        <p class="" style="font-family: sans-serif; margin-top: 0px; color: #212120;text-align: center; font-size: 16px;text-align: center;margin-bottom: 4px">Por la participación y exelente desempeño en nuestro curso online iniciando en {{$dataViews['course']->description}}</p>

        <p style="font-family: sans-serif;color: #212120;font-size: 14px;font-weight: 400: text-transform: uppercase;">FECHA DE CULMINACIÓN: <b>{{$dataViews['fecha']}}</b> </p>
    </main>


</body>

</html>
