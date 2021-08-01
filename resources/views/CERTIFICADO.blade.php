<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICADO YARE-STYLO</title>
    <style>
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
        <img src="productos.jpg" height="100%" width="100%" />
        </h4>
    </div>
    <main>
        <h1>Certificado de finaliazación </h1>
        <h4>Este documento certifica que <b>{{$user}}</b> ha completado con exito el curso <b>"NOMBRE DEL CURSO" </b>
    </main>
</body>

</html>