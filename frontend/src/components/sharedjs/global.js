import moment from 'moment'
export default {

    //funcion para convertir decimales a horas, si no se envia los paramtros opciones devuelve hora completa
    decimalToHour(a, only_hour = false, only_minutes = false) {
        var hrs = parseInt(Number(a))
        var min = Math.round((Number(a) - hrs) * 60)
        hrs < 10 ? hrs = '0' + hrs : hrs
        min < 10 ? min = '0' + min : min
        return only_hour ? hrs : only_minutes ? min : hrs + ':' + min
    },

    getHoursByMinutes(mins) {
        var decimals = mins / 60
        return this.decimalToHour(decimals)
    },

    formatPrice(value, symbol = 'Q') {
        let val = (value / 1).toFixed(2).replace('.', '.')
        return symbol + ' ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },

    //obtener mes por numero
    getMonthByNumber(number) {
        var months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
    },

    returnMes(mes) {
        let self = this
        return moment().month(mes - 1).format('MMMM')
    },

    //formatear codigo para tarjeta de reponsabilidades
    formatCode(n, len = 4) {
        return (new Array(len + 1).join('0') + n).slice(-len)
    },

    //obtener full name
    getFullName(data, tercer_nombre = false) {
        Object.keys(data).forEach(function(key) {
            if (data[key] === null) {
                data[key] = '';
            }
        })
        var pn = data.primer_nombre
        var sn = data.segundo_nombre
        var tn = tercer_nombre ? data.tercer_nombre : ''
        var pa = data.primer_apellido
        var sa = data.segundo_apellido
        var name = pn + ' ' + sn + ' ' + tn + ' ' + pa + ' ' + sa
        return name.replace(/\s+/g, " ").replace(/^\s|\s$/g, "");
    },

    //funcion para convertir numeros a letras
    numeroALetras(num) {
        var data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: "",
            letrasMonedaPlural: '', //"PESOS", 'Dólares', 'etcs'
            letrasMonedaSingular: '', //"PESO", 'Dólar', 'etc'

            letrasMonedaCentavoPlural: "CENTAVOS",
            letrasMonedaCentavoSingular: "CENTAVO"
        };

        if (data.centavos > 0) {
            data.letrasCentavos = "CON " + (function() {
                if (data.centavos == 1)
                    return this.Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular
                else
                    return this.Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural
            })();
        };

        if (data.enteros == 0)
            return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos
        if (data.enteros == 1)
            return this.Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos
        else
            return this.Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos
    },


    Unidades(num) {

        switch (num) {
            case 1:
                return "UN"
            case 2:
                return "DOS"
            case 3:
                return "TRES"
            case 4:
                return "CUATRO"
            case 5:
                return "CINCO"
            case 6:
                return "SEIS"
            case 7:
                return "SIETE"
            case 8:
                return "OCHO"
            case 9:
                return "NUEVE"
        }

        return "";
    },

    Decenas(num) {

        var decena = Math.floor(num / 10);
        var unidad = num - (decena * 10);

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return "DIEZ"
                    case 1:
                        return "ONCE"
                    case 2:
                        return "DOCE"
                    case 3:
                        return "TRECE"
                    case 4:
                        return "CATORCE"
                    case 5:
                        return "QUINCE"
                    default:
                        return "DIECI" + this.Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return "VEINTE"
                    default:
                        return "VEINTE Y " + this.Unidades(unidad)
                }
            case 3:
                return this.DecenasY("TREINTA Y", unidad)
            case 4:
                return this.DecenasY("CUARENTA Y", unidad)
            case 5:
                return this.DecenasY("CINCUENTA Y", unidad)
            case 6:
                return this.DecenasY("SESENTA Y", unidad)
            case 7:
                return this.DecenasY("SETENTA Y", unidad)
            case 8:
                return this.DecenasY("OCHENTA Y", unidad)
            case 9:
                return this.DecenasY("NOVENTA Y", unidad)
            case 0:
                return this.Unidades(unidad)
        }
    },

    DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + " Y " + this.Unidades(numUnidades)

        return strSin;
    },

    Centenas(num) {
        var centenas = Math.floor(num / 100);
        var decenas = num - (centenas * 100);

        switch (centenas) {
            case 1:
                if (decenas > 0)
                    return "CIENTO " + this.Decenas(decenas)
                return "CIEN";
            case 2:
                return "DOSCIENTOS " + this.Decenas(decenas)
            case 3:
                return "TRESCIENTOS " + this.Decenas(decenas)
            case 4:
                return "CUATROCIENTOS " + this.Decenas(decenas)
            case 5:
                return "QUINIENTOS " + this.Decenas(decenas)
            case 6:
                return "SEISCIENTOS " + this.Decenas(decenas)
            case 7:
                return "SETECIENTOS " + this.Decenas(decenas)
            case 8:
                return "OCHOCIENTOS " + this.Decenas(decenas)
            case 9:
                return "NOVECIENTOS " + this.Decenas(decenas)
        }

        return this.Decenas(decenas);
    },

    Seccion(num, divisor, strSingular, strPlural) {
        var cientos = Math.floor(num / divisor)
        var resto = num - (cientos * divisor)

        var letras = "";

        if (cientos > 0)
            if (cientos > 1)
                letras = this.Centenas(cientos) + " " + strPlural
            else
                letras = strSingular

        if (resto > 0)
            letras += ""

        return letras;
    },

    Miles(num) {
        var divisor = 1000;
        var cientos = Math.floor(num / divisor)
        var resto = num - (cientos * divisor)

        var strMiles = this.Seccion(num, divisor, "UN MIL", "MIL")
        var strCentenas = this.Centenas(resto)

        if (strMiles == "")
            return strCentenas

        return strMiles + " " + strCentenas
    },

    Millones(num) {
        var divisor = 1000000;
        var cientos = Math.floor(num / divisor)
        var resto = num - (cientos * divisor)

        var strMillones = this.Seccion(num, divisor, "UN MILLON DE", "MILLONES DE");
        var strMiles = this.Miles(resto);

        if (strMillones == "")
            return strMiles;

        return strMillones + " " + strMiles;
    },

    getLogo() {
        return 'data:image/jpeg;base64,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'
    },

    getCircleLogo(){
        return 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhUSEhMVFRUXFRUVFhcVFxgVFRYXFRcWFxUVFRcYHSggGB0lHRUWITIhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGy0lHSYtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAKIBNwMBIgACEQEDEQH/xAAbAAABBQEBAAAAAAAAAAAAAAAEAAIDBQYBB//EAEUQAAEDAgMDCQUGAwYGAwAAAAEAAhEDIQQSMQVBUQYTImFxgZGhsTJSwdHwFCNCYnKCM7LhFSRDkqLxBxZjk8LSNHPD/8QAGgEAAwEBAQEAAAAAAAAAAAAAAAECAwQFBv/EACwRAAICAgIBBAIBAgcAAAAAAAABAhEDEiExQQQTIlEyYfAUgTNxkaGx0eH/2gAMAwEAAhEDEQA/ANS7Boerg1dFqa5gXzqUkfTbmdfhkwUlfVMOEO7CLdU+ydvoqDSUbqStX4bqUTsMj20P3GVzQQpQ87wifs6c2gFlkwRfg0jlYE5oO5RHDtO5WFTDRcKEBRHA3+JTzJfkAOwIXBgArPKCmcyunHgmzKeeCBW4OFKygApxSVJtTab2uYaTZYHEPLoAdOmQkzbsXQvTyXbMH6mPhF5TgIuispsjaGQZKjnvJJcCdQDFr63k671o8JWkZhcFar0qfkh+ra8FgGroqAIU11C+sVa9LBGT9VJli7FAKJ2MVY+oVEXlWsK8IXvP7LcYsJxxrVRl6WdJ4BrMWD68lcFZV+cpc4pfp0WvUssefTefQPOLhqqf6dFf1LDjWTDUQfOpGoqWBCfqLCXVVGaigL00uVrEiHmZOXpuZRSlmCftoXuMllcJTMyWdGobjiuJmZdzJ6huOlclcXQFOpW4l1cJSS0HubjKlza7IXCV5XtsuxpppvNpxKY5yrRj2OOphRmm1J7yoSSmsa8sez+h5pNQ9WiNycXHgnseN4VKDXXInP7BRhzuUjcEDqiMnBT02rqjjk+uDnllguwVuFaNyDxNRrX5Il0ZoG7hmO5XgYqPlJs0OGbO+HQC0GB0YsCLxc795WqxvGnIz91ZHqZna/KBocKTYqVCYDActMEXuT7R6kFR2Zzoc+vD3yIiQGDg2/mqbbmy6hxLalOmeapVKDSW6MzOaQSOs5rrcYSh0Xdo+KzUm5L9mtJJ/owbsRXYSJa9skBrxcCdzkZszlO0EtDzTIPSBiozhfePJSYzDe1+74rBbDaedZGsjw3g9oWkZPlmc+Gl9nrbuUIFMv5vPpem4ZT2g3Hmr9lMOAcJggESCDBE3BuFjNmbFY9xERMTl6J9oTEaLdsptY0MaIDQABJNhpc3K6cTc1ZjlSg6BX0UPUpKxcJFtUNUpLojjI3AHU0ubRJpLrKKcoJBuCiklzSnxeFGekS4tOYgXsZabEGxvAnW+qLOHXO0UpFU6moy1WrsOonYdA7K0hNIVg7DqN2HTFYFlShFGimGkgCBNKnNMphpoDkilKU8sTcqfAWxBy6HJALhCVIpNjw5cNXgozKaUqRWzHl6SiKSmh7G/a+dJ7wR6p2U8LfW5FU2AarriF5T746N1L9ARITHOCIqNUMDelGEWU5yXREaqYaxUjw1DvKtLFHshyyvodmJT2MQ+cqVlQreOTH4MJxyeQtlNTCmoKVQoynddMJxfRzzjJdjWsQG3h0G9p/8VcMpqs5Stim3tPwVZfwYYP8AERm9hY+hTfiqdZ7GmoGBgeYzkMcIE75cLdalwXsntCy20dkvqVxUkNa1wdxJjLoO5WlXEuaOiSL7lxRyU4/o9F4/y/YGaAc/KdC6D2EwfVVu39hUaOPikwMaKdMgAWksbJ7Sj3VDMzB1kWg8Qq2nhaoeHOeH3lxM5j1mZnxSbdUgcfkmanYdLp93xatJVo3Wf2Men3fELbuwkrv9NKonF6v8kUYppzqUq2ODQOJxlFmrsx4NuO92i6XkRzpMEGElTHDtYMz3Bo4kx4cVU4vlEbimAOsXP+Z1vJUOKxT3kkuM9pn/ADG/csZ50bwwyZYco9sUhlyGSw5gYjpAgiBqdN8K/wBl4llemKjO8b2ngVgX0NfrxKM2FjnYapIu02cNxH19ag4RyWzWeLjg3hwyidhlYYaq2owPYZafqD1p5ongtjm2Kd2GURwyt2U8wltxJHeCQfMFcdhkDUimOHTDh1buoJpw6TRamU7qPUoXYYncr37KuGkoujTspWbOnVDV8JBV/UbCDqMClzkawhEqDTUZarN7AoHsCW7+i9F9gDgoyjHtUDwnuw1X2DlJdeEkbC1R6OQVG6VOfqFC9pXk+8ikrIc/FR1U6owpUhNjZYSyxTuJqo8cgryoirZ+Bsh24MraMozXyVMhSa/FgTR1KVrUczBqdmEWscOP7FLNICpU0dRZCmbhk8USuvHGEfJyznKQ5iz/ACmBLx+gW73LQBhXn/KMYmnWLDWzAtDg6CXQSYEGzTY6QFpOUZKicScZWC4p7RdxA+vrRVzsYx1g0kcfqELz9M1uZLi6rlznMCbWv7u8byi3ggfQ8hZZVFdI6rcvIzoHRxHb9fFPFA7iCoyZ3fXgmg9R7v6pNr6Hz9llhczdWn19FocPyyYaTcjQHAZDmJcczOg4ZR1jis3harhoT3i3r8FLmInMxrp3yJ8/krxzSM8kXLtBG0Nu1KntExwPwYLDvhVdSqXame35aeMormqR1a5np5rn2Nv4ajf3dHzVtyYo6oDKcApn4R4vEjiCCmOYRqCO0LOmappjCE0sCkXSEgLHk5tg0H5XXY7UfEdf1wI1O09tUQIFQCRrIE92qwbmygtqYF1YMLHFlam4OZBIDwCJY7rtY9y1U21RhPGk7NadpENdUpOdDCC4wSI3y0xI10lW2A5QUa0AGCbW6QkkAC1xrvA0VXhWzSrj8vz+azPISi37U7OAf7zVib6udA8gnDK2k2LJiVtHqPMpZFNCTlbbZkkkCPYoXhGOamGmpLsrKlNDvoq4NFNNBLYtFG7DqJ2GV8cOFG7DKXNmiSKB+HUL8OtA7DBROwwS3NFFGdfh0leuwwXFPuF6I1NDZFNumbvcVMcKALCe3VQnaI/CQesER6p9LFOdo2Rxiy8tPD1E4pe4+ZMidRPueYj1TDhz7nm35qya49UrvarXp0/JPvNFfSon3Y7VPzfUioC6IW8MFEvI2DNozuhJzCNyIq1GNEuIaOsgeqzW1OXWEpksYXVng6U2l0HgTuWuiQlKT8FrjMc2mBmygkgAHeJAJtwCndWaBJIAOhmx7F5XtTlNUr1TUDGUgQAM8uMD8jDrbXN3IF7qtQZXPqvHBx5tkcCxkBw7ZVNJI1WNs9C2ryzwlElufO8WyMlzgetoBcPBY3bO3+eeKjmino3KT08okh2VuYySdDl7t4WHwJAgQwcGDKPJdq0hTEnSQJ3knd1pRq/s1WNx5K2nQ+/NdrXucQ5ozxTYGnLqBLjGUXsj+cq6ksA90MBHeXSSm86dzfEx6SrrBYBj2tJm4vrr1d/FbR2k+AajHsqKdQ36DDfcC3cL9EqZpbvY4djgR4EKTaWGFNwaydJOa+vCI4KNimVrhlJJ9BuFaz3iO1seYJVk3CZh0S098eRgoDBUc0AETBMX3a7oRdSkIh28AjfY3HYsZLzRSfhMnwDeYqZ3UucsRlcLEnhY/FUuMHSMtymZiIie26sDTkdCeEtnzIQ1XP7xP6gCP9SqL4JqnZTYyQ0lpLbbiR6yixiHgWce/peZ0UGMxMWe1hbPStkgcTl+SOcWNLGOazM+cgkhxjUiBcCRfS4G9bRTfTIk4rtAuL2hTpsdUqsaGtElzSW+WpKbgcbQrMFSm9wafebPdbRR7fwTK1GpRBLC4RJBe0XBm19yA5N7PNGgGZ6ZOYkZXEAi34nARoq8cit7cdUXDGB3svYb8YPmuVaDhqCOvd4ptDCG4Am5OoIg8DN+1TFr2b3DvMechTSLTYXszaMB7XAyWEW1cgOTv3WIzvMM5zODrYzmtqm4qo4i7WuMjVokX1kQnh43tjrafg5N0+hV3Z6Phto0ansVWOndMHwN0SQvKaIazKHVGkWa5zy1pM2vBAB7Ci8PjcRT/h1HgDcDmb4aKrMvbt9npUJQqvkviX1KGeoS5xc6TaLGLAaaeMq3soc2GlEeVcLQpSQmOeEm2ylSIy1MLE81AmGqFOsilNDHU1G6kpTUTDUS0kWsqB3UklKXrqekh+6ixIbvYw/sb8l2nkaZbTYD1AA+ia+ACXQABJJNgOJkqDD7SoVMzWVqboscj2yMwtobFci1vpHOwba/LLC4YltV5zgSWsa5x0kAkCGz1rMYn/iYHewMg62PcfGI8li9uvcQS5znEvBJcS5xJBNyVVMK6MTtWU8UYuj0IcvN5rv/AO0f/VQVP+IVd4Apua0GRmIzO72jKGnhf4LDPKn2WAJ/U3yIWj5DVGjrUqlaTVe+pIIOd1iD+VkA98ruEwJgtcbNOWBDQbAgwNNVHs7aLagOUk5XFpsRcROuuuqOwz/a/V8AsnFo6I6kYwTA5oAgQ71HzKIbTA0/oqTlRiqjDS5t5aS69mmRLbXFu5X5KlxKT5aGQd/khtqPbzTBvzg6Hg7fEeaJe6LqHbJ+4p/rHo9a4fP+Rnl8FZK0uyA/I27Yg7iTrxzD0WWzLVbHd90zsPqVth7MsvQBtv8AiXj2RpbeUGxyn2+/70foHq5VzHlRk/Jlw/FF5spxziJkteBGuilGIBDSNMjPJoHwQuwH/fM/d/KV3GubTc1kgdFoAJAJ6I0G9Jq8f9xJ/P8AsXGwarQ953lrR3An5qoxtZmd0m+Y3gum51KP5Pv6b/0j1KxvL/8Ag1LkRWFwSD7R3jtVJfFImTqUmF7SyljjnBsbdObDcCFcVATiMK6P8KtA/wCzf64rz3ke9zqdfM9zosMzi6BG6TbVejj28KfyVB4imfgtIKm0Q5bRTKvaeBfld0HRf8JMibjvCr8AJzRljqNpl07tYy27ETjeWXMYmpRr5mMaTlcxzqjj7JEsy2BDuNo3ozA8s8NUcGMxLy46B1F3rkR7X7H7ysH2fRPM1IgOFRrQYBIa51Oe8Bzr/JFYtxa9zQSADp+HwNkTTHSxLYaIqUzYG9qbiSJjwgWVJjduE4+phebiACHdGCOba7hO+NUST1CMltyE4pzmtzQLiWy2J7MsSpXH8vgY9QfVQcrsQ+nhKdRmUZWCczS4ZQQCQARe6LxTXEg1IzljC6BAzFjZgSYEzvKlxo0jO3RScpmjmZk9GpTdB6niwjt6lZkDiPHL5WTeV2zDWY+iwsa54aWBzg0dHK51pn/dda4Bty0wL5XNcbDcAboaaEu2za8jY5h15POGbzaGx2alXmdZfkFjW1KDy0OA5w2cMpmADadLBaCvVDQXGYHC5T1XkxcnfBMagTDVCqm7bpOLms6ZYYeGupktPBwzy09qg2dyho1i9olhYSHc4WgWJbqHEatPgp1iVtIuTVUFeuGgudYDXU+iBrbdwrfaxFBvbVYPisftvalM/wALbAaSXF0w5o91rRRykb9SdE6ropLzLg3VGuHiWyR2EeqbWxLGe25rf1OA9V4diNp1vxYvnB0rAVInpZZzAkAmNJKGfiWOYcz3B59xzwBcb7Tad2/vRcn4E3iT7/4/7PbKu38K3WvT/ac38spLwapzOji936jm9Skj5fX8/wBStsX3/v8A+HNubfxeIcTiKxcTLSwOIYMsCObHRFxwuUNgaP3rGEGecaCI0OYAg8FJUaPaexgzXu34ZlYYDaTDXpOqPLg10WbM5iTLySTq4mZ8UqSjUUcdXLlmt5RtOUdbx/KVRtK0m0wyoxplxEyMozTY8FXfZmAkZKhjflIGsWJkf7LmxSSjR6ORXKysc5FbPOnaiHhrYikSSLDMwGJ1GiKw2HfVqClSp5hIBLyYEDpn2rAGRO+Ota7GdHNkNNNrs4yy8uvbWPkj6W1KQn7xuu45vRM5Q7Po4RgLqrS91mMbTAJvckl1mjiqotrGYc0CTA6t0wOCV7Ap1wgnaeKpVnMgvOUzak8kmQYEwN3mr2jUrv8AZwtf9zQ0epVJsTlBQw1Uio8GtDWNGV7spOrhFhMi/UrLbX/EWnSGV2eXNJaWt3xAMk7laxp1YnlatgG1tsuY7mzka4GHAOziZjK8hto4AghWO0Xk4akXEElzSSLCSxxMDvXnzds0X9BjH6alo0EfmJ4LbYup/dqPaz+Qrb24xT1+jGOWU38gcFavY5+6ZHA+pWNa9X1bFvp4POx2VwaYMA+8dDbcox8Ns1ycoErMxGZ3PkF2Z2SAB93mIZYbzfyXGhE4HG1KudtR2cNDIkNEZmUiTZvF7vFFNot90JSjbtFRlqqYth/xmfu/lKm2psYVq7KsiaYOUWOaRET+GCAU/BgB4gAa+iyuMpN57FWH8Sh51Gz2TKaqMaf84JfylaNhsJpbVeHAg5Rr2rM8s8JUq061Omwl3O2EgZgHAkySAN/gtHss3tboN07EzEnpu7T6n5qtaSE3bd+TCcltlV6Lawq0y3NcXaZsB+Elbxzg1uHc6waHF3UMl+3RQVdO5d2gJot/S7zpu8NE122TVJIzvKx2FxRLWPDKzXO/w6l4ADg/KyTAZ5LNcl6ThiGEtIBDrn9JI3/lPgrd3/znW1qVP9TXfNRbFxU1KQhokagX/hTbxRF7OyMkKaN4R97iusMcO6mPksptXAVP7V50MdzZpt6UdGSyNf2Hy4idWD97U66TD/od8k3Hi4iT0RfXTMql+JSVtA+I2vTo02F7HuLKebogEBr3ZLibmUPhtptxWZ9NrhHROYAaAG0E7iEBt0dF1zfDv7slSm74qHka4ZHzueD4tH/qs9reppVfI11ZrS6mTEtbfiJaAe3d5KnxOy84yueaYsS5kF1uqDKPqMbINvZI8Y+She5om49kxfhwVtJkKTRS7WrloDdm1X0iTULqbBUp84WE5odljMCd5A6RuqKpS2o+znYh07nVrd8vhW+zngVWXsK+Lb3Oax4v3rQ842NTpxKcXZE8fJjsfyby025KwdiNatPNMlxOTJbWztdSDCA2dyd5w/3l4oEA80Hloe+pIgBpBOXSSINxC0ePrhuILt2SkT+2tH/mheU+Mbnova6cjriZynouAI3GyUp0mCwxbRRtwO0AA2nTbABh7cplpM2dvBt4LmM5M4uGua+maj5L6efpMJJMiDcGHGALRF9VucGSWwGkwXtsfdcRxQ72EYlliJA78oqj/wDRNUuRyuS1k+DG/wDKGMLMz3saZENc4S4HgJ3dcG+iVTkZimhpLmAEEkausfdAnSPqy2m1KbgKTvdeZvuyPAMduVRbW2kyiW15a8Uw8ODXguyuiSB+0KrM/biZJvIyudXNHcktDT25UxDh9jNBzQBmFQvFRrjO5tosLzxXFVE6x+jCY6hnYDEAST2XUuBxdNrct9275JlTnTIFOpEAXY4aDs7VCyjUGtNw68rvkudLwO+bPR9iv+5YeLQR3rM4pxfUxTTMOr4Vvi6DHgpNm7WpsOZzHtcWNY6GOjozEWQ4r0i97zUjPWp1LtcIFMzEwueMGm3X8s65TUopX/KC9u7NpspU4noGnSbPul7T49EK3pYt7M2Rxb0nTlJBs9x3blTbWx1Oo1gbUYYqMcbxYGd6npYkFpuL5t/Ek/FVzXIfHZ0Y3+0KtZ4dVe+o5zmy5ziT2a6dS3FJuW+YXi2aT4blh6GDqh4AafbEAEEnpDcD1K1x213Ne8ACBlbmaWuLTPSmDBtPet3G+jlxy1tsHxdWcWKggtc9oBsfZiRGrdQdyXK+7qf6UAzH04BLXZ8+bnNTluQA22riSST62L2hiKVaC+sGwBlDWue7sdIa0G+4lVpymRvcWn5ObDw5D5j8J9QvQMRUY6jTYKjA4ZZBcNzSDp2rE4Cu0OhpmGCSRkub2Em0RrxRj8XcaqG2m0a461NCKH/Up/51Y7SrMGDLOcYXBrrNcDucbQVk/tttCuYjEAtdrZr/AOUpJml2aLZuMpsc/NVYJbTsTcfd0hfuafFWTdo0h/j0/EBYanVaahJvanqP+mzw/ojzXBgSDEQfAQfEjuVcE7ts2OH2nQBDjWpkb4e0ai15VDiqzDWxLs7QwuoODyRljPTIM77Kve4Ru3aHeNw8D4qGrUH3oMTlof6XUgpb6RUX2bbAbWwzYJrsNgD940CwAtdSv2hhnEkVqZndzzBr4rBN4FotrGt7epCNY4EcJE3IMmOjvuJjyVtkqTNXUxuHOlal34hnyXHYym5mTnKOkA8+0/hLeHXKydenA6IPEzfS95PWdNVzmxDS4TxggC8Bo69ZKV0O2KrUy44f/ay4iLhtx4q4wOxyMjs7zA0L5/CBfo9U+KzdeftTD+agfFtMhasV3ERzZgEXmNNP6d2hCWLyPJzQcXuDgYbJGXUxAB18Sn1Kjz7mnCfXtQn2hxyksIIdGov0T3fC/aoquIcTm5ozEDpRIvPZ9cFsRYBtis+cro/hVwIAA9hp0/ag+SmOYwVc7i0TTuATfp8AYRG0yS6mTYkVG+NKp8gqDZJltUTuaePvD4rB8TNL+Jtf+YKHtDnH9cDyzZeKydLbtKvjG1HU4FNz20zJBId0TmBtMlxnsG6UynVAtNr9hnUEd0LJVQadV7g0uax153ZtJPFad9GDlVWb9uNbnkMI+9JyudrnpFvtAW9hEf206OjRpgR+IucY74VDhqnSn82HJvx5wH1CIp1b9GToIbJ/ETp4KVwaN8Eu0tpucC57WCGOnKCDAh8SXG3Q8lkX7RzVajiwN5x2YhsgBwzbifzGVpsZSJs4QDnBzFrfaY4AQ4g3JCx2IhlZwcczQ4yREuBm86TdWo7JkOdHoVHHPyw2o4AkkQ4gdIl249agNdxPScTIIuSdXM3kqkw+36Qa2ab3dEA3AFgAYgz+Fdq8pG9Hm6AaGkRcuNtLwbaeCSixuasumybhu9skN0uAb7kZh6FRr21CCGhwJNtDAJA71m63KzEusA1oiNPmfgha228U8EGoQDOkCxtAtI8VSiT7iPRKOK3QJuQRoQDHaDfRdXmtPaGJERVIgEcSQY1J10GqSu2Lc0dOqg8TiS4nWPq6nBVYSevsXOkaNkhf1eBTc5+pTS3tTSI3qqIseZPDvy/Eyon0xu+HzXS4rrXxpZOhAmIw2YRPDU2tuiUBXwT+E6X3eH1vVuXHr813Nbf4pkuKZRfY3j8M9t/9k37I8aN7/UK9B+rpPaIn69U7Foiqw+He3QwfrqREVCiz2DxC4QOpIaREKlQfX9U8Yx+9ki8iSJBBB0M70o+voJpHWjUds6ccc2YUouJ6TtAAAPAKWltYg+w8DWzgfJwHqoO8rsdqKFyWH9q0x+J2s3aDfuI4Bdr7RpFrjnOZzWCObcIIcxxMzBHRPiq4NTsg4BLVFKTCqe0WzGeJFyWvaDrAMcFYU8cwEQ+l3Ov5gKlIHADsUbg3rRqCk0X5xZk5CD+9sHuJUhr3AcH5dCQWkAWmNfiswWhOFB+okd1knAamy8rY+g9zXN50PBpASWkHJlbcAAyQNy0H9sUi0tdn13CJg9qwIwLuJHgnjAn3j3f7pxjQSm2brEcoKZywH+2Dp5JV9t0jDsr5ExMR4ZliW4M8Xd0p5wG85o6zCsWzL/F7YY+pTiQGvEglotlcJF/zcVUYV5ptfmgS0AEuAuHtO6+gKFdgG+93Xd6CFG/AgaHxAChxTdhu6Jzj2jVwN5gAu8zCAfigRWGUnnHEiSO6QBe6lODHvHuSGF7T3x6KkiHbHYfabmQQGCzQZBcZboekUq206zrGo89QOUeUBdbhQNLJ4pBMOQAgm8X4kklQuw5LpIPlwVvzfUlzXUmnQqAcLRgXF+5FNYphTToQNIiDEsqeXKNzkAdLklC56SANKWRoQquuw5jc6rd7c5S7PqMLaeDgxZ0NpR19HXvWAq03TYSDoSsItvs2khslOBPBJtJw/CuOeVdkDmk8EiU0Ert0wOGEpCWc8EwVOpADyxMyJ4ckXBMRG0JOUrRJgCT1JVKRaYd0f1WQBB3JQin4SLh7HD8pk+BhIUgBN9dHAhp/dKAoEhdDd8FWlNg3UyCfdLKo/wAhEwe1S1aRbfMAT+GH0D4HooCirZhnm4bI46+IF09uDvBPhr4OIKKeXgSWR1nI7zF112JI9l0/pzejgQgdDG7MbvLu2CB/qHxTmYRu5rT+6fISmGudw8YH8sLj67jq4dkT/NKApBtKmJDQ0AzHRAab7pddMxLGscWkiRwJd4WCANQaSSO23gm85wACACc7Nwee2Ao3VOzqkz5KGXFdFNAiQ4jrPdb+qZznV43KWSEu5ACgrhaEiU0uTAdAXFxdQApXUgE6AgDkJErjnKIuQBIXKJzk1zk1wQI45yjLk4tTYQIaUl3IkgC8YJ1RtBog23H4LqSxN4ldV3Ljx0QkkmSDNUm9JJWSccfRRFcSTAcNU+kfikkgBz2i1t6gm8bkkkCHhoABAg9VlrOS123vIMzvSSQVDsD5T0GMPQa1tz7IA9EA/G1TRg1HxYRmMRwiUkkDfYHRAjvTnJJIJIqpUYSSQB0apw+a6kgRI0LkpJIA4U0pJIAYupJIA48afW5ShJJMDhTCkkkBC5MBSSQI7uC60WKSSAInJgSSQIcupJIA/9k='
    }
}