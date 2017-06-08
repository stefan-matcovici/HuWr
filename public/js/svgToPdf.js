var centeredText = function(doc,text, y) {
    var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
    doc.text(textOffset, y, text);
}

function svg_to_pdf(svg, callback) {
    svgAsDataUri(svg, {}, function(svg_uri) {
        var image = document.createElement('img');

        image.src = svg_uri;
        image.setAttribute('width','725');
        image.onload = function() {
            var doc = new jsPDF('portrait', 'pt');
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var dataUrl;

            canvas.width = image.width;
            canvas.height = image.height;
            context.drawImage(image, 130, 0, image.width, image.height);

            var w = image.width;
            var h = image.height;
            data = context.getImageData(0, 0, w, h);
            var compositeOperation = context.globalCompositeOperation;
            context.globalCompositeOperation = "destination-over";
            context.fillStyle = "#ffffff";
            context.fillRect(0,0,w,h);
            var imageData = canvas.toDataURL("image/jpeg");
            context.clearRect (0,0,w,h);
            context.putImageData(data, 0,0);
            context.globalCompositeOperation = compositeOperation;

            dataUrl = imageData;
            doc.addImage(dataUrl, 'JPEG', -150, 0, image.width, image.height);

            callback(doc);
        }
    });
}

/**
 * @param {string} name Name of the file
 * @param {string} dataUriString
 */
function download_pdf(name, dataUriString) {
    var link = document.createElement('a');
    link.addEventListener('click', function(ev) {
        link.href = dataUriString;
        link.download = name;
        document.body.removeChild(link);
    }, false);
    document.body.appendChild(link);
    link.click();
}