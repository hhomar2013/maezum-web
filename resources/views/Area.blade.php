<!DOCTYPE html>
<html>
<head>
  <title>أدوات تحديد المناطق</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.3.0/ol.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    #map {
      width: 100%;
      height: 500px;
      margin-top: 10px;
    }
    .toolbar {
      margin-bottom: 10px;
      padding: 10px;
      background: #f5f5f5;
      border-radius: 5px;
    }
    button {
      padding: 8px 12px;
      margin-right: 5px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #45a049;
    }
    #clear-all {
      background: #f44336;
    }
    #clear-all:hover {
      background: #d32f2f;
    }
    #info {
      position: absolute;
      bottom: 20px;
      left: 20px;
      padding: 8px;
      background: rgba(255,255,255,0.8);
      border-radius: 4px;
      font-size: 14px;
    }
    #save-form {
      margin-top: 10px;
      padding: 10px;
      background: #f5f5f5;
      border-radius: 5px;
    }
    #save-form input {
      padding: 8px;
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <h2>أدوات تحديد المناطق على الخريطة</h2>

  <div class="toolbar">
    <button id="draw-polygon">مضلع</button>
    <button id="draw-line">خط</button>
    <button id="draw-circle">دائرة</button>
    <button id="draw-point">نقطة</button>
    <button id="clear-all">مسح الكل</button>
  </div>

  <div id="map"></div>
  <div id="info"></div>

  <form id="save-form">
    @csrf
    <input type="text" id="feature-name" name="name" placeholder="اسم المنطقة" required>
    <input type="hidden" id="feature-coords" >
    <button type="submit">حفظ المنطقة</button>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/ol@v7.3.0/dist/ol.js"></script>
  <script>
    // تهيئة الخريطة
    const map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([31.2357, 30.0444]),
        zoom: 8
      })
    });

    // طبقة المتجهات
    const source = new ol.source.Vector();
    const vectorLayer = new ol.layer.Vector({
      source: source,
      style: new ol.style.Style({
        fill: new ol.style.Fill({
          color: 'rgba(255, 0, 0, 0.2)'
        }),
        stroke: new ol.style.Stroke({
          color: 'red',
          width: 2
        }),
        image: new ol.style.Circle({
          radius: 7,
          fill: new ol.style.Fill({
            color: 'red'
          })
        })
      })
    });
    map.addLayer(vectorLayer);

    let drawInteraction;

    // تفاعل التحديد والتعديل
    const selectInteraction = new ol.interaction.Select({
      layers: [vectorLayer]
    });
    map.addInteraction(selectInteraction);

    const modifyInteraction = new ol.interaction.Modify({
      features: selectInteraction.getFeatures()
    });
    map.addInteraction(modifyInteraction);

    // وظيفة إضافة أداة الرسم
    function addInteraction(type) {
      if (drawInteraction) {
        map.removeInteraction(drawInteraction);
      }

      drawInteraction = new ol.interaction.Draw({
        source: source,
        type: type,
        freehand: false
      });

      map.addInteraction(drawInteraction);

      drawInteraction.on('drawend', function(event) {
        const geometry = event.feature.getGeometry();
        document.getElementById('feature-coords').value = JSON.stringify(geometry.getCoordinates());

        if (geometry.getType() === 'Polygon') {
          const area = ol.sphere.getArea(geometry);
          document.getElementById('info').innerHTML = 'المساحة: ' + (area / 1000000).toFixed(2) + ' كم²';
        } else if (geometry.getType() === 'LineString') {
          const length = ol.sphere.getLength(geometry);
          document.getElementById('info').innerHTML = 'الطول: ' + (length / 1000).toFixed(2) + ' كم';
        } else {
          document.getElementById('info').innerHTML = 'تم رسم ' + geometry.getType();
        }
      });
    }

    // أحداث الأزرار
    document.getElementById('draw-polygon').addEventListener('click', function() {
      addInteraction('Polygon');
    });

    document.getElementById('draw-line').addEventListener('click', function() {
      addInteraction('LineString');
    });

    document.getElementById('draw-circle').addEventListener('click', function() {
      addInteraction('Circle');
    });

    document.getElementById('draw-point').addEventListener('click', function() {
      addInteraction('Point');
    });

    document.getElementById('clear-all').addEventListener('click', function() {
      source.clear();
      document.getElementById('info').innerHTML = '';
      document.getElementById('feature-coords').value = '';
    });

    // حفظ النموذج
    document.getElementById('save-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('feature-name').value;
      const coords = document.getElementById('feature-coords').value;

      if (!name || !coords) {
        alert('الرجاء إدخال اسم المنطقة وتحديدها على الخريطة');
        return;
      }


      // هنا يمكنك إرسال البيانات إلى الخادم باستخدام fetch أو axios
      console.log('بيانات الحفظ:', { name, coords });
      alert('تم حفظ المنطقة: ' + name);

      // مسح النموذج
      this.reset();
      document.getElementById('info').innerHTML = '';
    });
  </script>
</body>
</html>
