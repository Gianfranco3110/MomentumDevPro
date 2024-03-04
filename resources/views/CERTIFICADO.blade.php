<!DOCTYPE html>

<html>

<head>

    <title>CERTIFICADO YARE-STYLO</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        .parisienne-regular {
            font-family: "Roboto", sans-serif !important;
            font-weight: 500;
            font-style: normal;
        }
        .cardo-regular {
        font-family: "Cardo", serif;
        font-weight: 400;
        font-style: normal;
        }

        .cardo-bold {
        font-family: "Cardo", serif;
        font-weight: 700;
        font-style: normal;
        }

        .cardo-regular-italic {
        font-family: "Cardo", serif;
        font-weight: 400;
        font-style: italic;
        }

        .playfair-display {
        font-family: "Playfair Display", serif;
        font-optical-sizing: auto;
        font-weight: 400;
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
    <div id="watermark">
        <img src="fondo_certificado.jpg" style="width: 1121px"/>
    </div>
    <main style="padding-left: 139px; padding-right: 139px" >
        <p class="cardo-regular " style="margin-top: -4px; color: #083762; font-size: 31px">COLEGIO BORCELLE DEL ESTADO DE MÉXICO </p>
        {{-- <h4>Este documento certifica que <b>{{$name}}</b> ha completado con exito el curso <b>"NOMBRE DEL CURSO" </b> --}}
    </main>

    <main style="padding-top: 10px;padding-left: 100px; padding-right: 150px">
        <p class="parisienne-regular" style="margin-top: 220px; color: #083762; text-align: center; font-size: 40px; ">{{$dataViews['user']->name}} </p>
        {{-- <h4>Este documento certifica que <b>{{$name}}</b> ha completado con exito el curso <b>"NOMBRE DEL CURSO" </b> --}}
    </main>


    <main style=" padding-left: 100px; padding-right: 100px" >
        <p class=" playfair-display" style="margin-top: 0px; color: #083762;text-align: center; font-size: 21px">Por haber obtenido el Primer Lugar de aprovechamiento con un promedio de 9.8 en la Generación 2020 - 2023 </p>
        {{-- <h4>Este documento certifica que <b>{{$name}}</b> ha completado con exito el curso <b>"NOMBRE DEL CURSO" </b> --}}
    </main>

    <main style=" padding-left: 0px; padding-right: 570px" >
        <p class="cardo-regular" style="margin-top: 79px; color: #083762;text-align: center; font-size: 21px;margin-bottom: 0px">LIC. ELENA PAULA</p>
        <p class="cardo-regular" style="margin-top: -4px; color: #083762;text-align: center; font-size: 21px; margin-bottom: 0px">DIRECTORA ACADÉMICA</p>
        {{-- <h4>Este documento certifica que <b>{{$name}}</b> ha completado con exito el curso <b>"NOMBRE DEL CURSO" </b> --}}
    </main>
</body>

</html>
