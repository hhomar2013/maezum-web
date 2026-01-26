   document.addEventListener('livewire:init', () => {
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

            const source = new ol.source.Vector();
            const vectorLayer = new ol.layer.Vector({
                source: source,
                style: new ol.style.Style({
                    fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 0.2)' }),
                    stroke: new ol.style.Stroke({ color: 'red', width: 2 }),
                    image: new ol.style.Circle({
                        radius: 7,
                        fill: new ol.style.Fill({ color: 'red' })
                    })
                })
            });
            map.addLayer(vectorLayer);

            let drawInteraction;
            let currentTool = 'Polygon';

            // ✅ تعديل الأشكال بعد الرسم
            const modify = new ol.interaction.Modify({ source: source });
            map.addInteraction(modify);

            modify.on('modifyend', function (e) {
                const geometry = e.features.getArray()[0].getGeometry();
                let coords = geometry.getCoordinates();

                // تحويل إحداثيات الدائرة لشكل بوليجون
                if (geometry instanceof ol.geom.Circle) {
                    const center = geometry.getCenter();
                    const radius = geometry.getRadius();
                    const points = [];
                    for (let i = 0; i < 64; i++) {
                        const angle = (2 * Math.PI * i) / 64;
                        points.push([
                            center[0] + radius * Math.cos(angle),
                            center[1] + radius * Math.sin(angle)
                        ]);
                    }
                    points.push(points[0]);
                    coords = [points];
                }

                const jsonCoords = JSON.stringify(coords);
                // Livewire.dispatch('set', {
                //     name: 'coordinates',
                //     value: jsonCoords
                // });

                    // Livewire.dispatch('input', {
                    //     name: 'coordinates',
                    //     value: coords
                    // });
                document.querySelector('input[name="coordinates"]').value = JSON.stringify(coordinates);
                document.querySelector('input[name="coordinates"]').dispatchEvent(new Event('input'));
                });

            function addInteraction(type) {
                if (drawInteraction) map.removeInteraction(drawInteraction);

                let geometryFunction;
                if (type === 'Rectangle') {
                    type = 'Circle';
                    geometryFunction = ol.interaction.Draw.createRegularPolygon(4);
                }

                drawInteraction = new ol.interaction.Draw({
                    source: source,
                    type: type,
                    geometryFunction: geometryFunction,
                    freehand: false
                });

                map.addInteraction(drawInteraction);

                drawInteraction.on('drawend', function (e) {
                    const geometry = e.feature.getGeometry();
                    let coordinates;

                    if (currentTool === 'Rectangle') {
                        const extent = geometry.getExtent();
                        coordinates = [[
                            ol.extent.getBottomLeft(extent),
                            ol.extent.getBottomRight(extent),
                            ol.extent.getTopRight(extent),
                            ol.extent.getTopLeft(extent),
                            ol.extent.getBottomLeft(extent)
                        ]];
                    } else if (currentTool === 'Circle') {
                        const circle = geometry;
                        const center = circle.getCenter();
                        const radius = circle.getRadius();
                        const points = [];
                        for (let i = 0; i < 64; i++) {
                            const angle = (2 * Math.PI * i) / 64;
                            points.push([
                                center[0] + radius * Math.cos(angle),
                                center[1] + radius * Math.sin(angle)
                            ]);
                        }
                        points.push(points[0]); // close the circle
                        coordinates = [points];
                    } else {
                        coordinates = geometry.getCoordinates();
                    }

                    const coords = JSON.stringify(coordinates);
                    // Livewire.dispatch('coordinatesUpdated', {
                    //     coordinates: JSON.stringify(coordinates) // coords هو string أو array
                    // });

                    // Livewire.dispatch('coordinatesUpdated', coords);

                    // Livewire.dispatch('coordinatesUpdated', { coordinates: coords });
                    // Livewire.dispatch('set', {
                    //     name: 'coordinates',
                    //     value: coords
                    // });

                    // Livewire.dispatch('set', {
                    //     name: 'coordinates',
                    //     value: JSON.stringify(coordinates)
                    // });

                //    Livewire.dispatch('input', {
                //         name: 'coordinates',
                //         value: coords
                //     });

            document.querySelector('input[name="coordinates"]').value = coords;
            document.querySelector('input[name="coordinates"]').dispatchEvent(new Event('input'));

                    // تحديث إحداثيات الخريطة في الحقل المخفي
                    document.getElementById('coord-input').value = coords;

                    // تفعيل الأداة الافتراضية بعد الرسم
                    addInteraction(currentTool);

                });
            }

            // زر مضلع
            document.getElementById('draw-polygon').addEventListener('click', function () {
                currentTool = 'Polygon';
                setActiveButton(this);
                addInteraction('Polygon');
            });

            // زر مستطيل
            document.getElementById('draw-rectangle').addEventListener('click', function () {
                currentTool = 'Rectangle';
                setActiveButton(this);
                addInteraction('Rectangle');
            });

            // زر دائرة
            document.getElementById('draw-circle').addEventListener('click', function () {
                currentTool = 'Circle';
                setActiveButton(this);
                addInteraction('Circle');
            });

            // زر خط
            document.getElementById('draw-line').addEventListener('click', function () {
                currentTool = 'LineString';
                setActiveButton(this);
                addInteraction('LineString');
            });

            // زر مسح الكل
            document.getElementById('clear-all').addEventListener('click', function () {
                source.clear();
                Livewire.dispatch('set', {
                    name: 'coordinates',
                    value: ''
                });
            });

            // تفعيل الزر الحالي
            function setActiveButton(activeButton) {
                document.querySelectorAll('.toolbar button').forEach(btn => btn.classList.remove('active'));
                activeButton.classList.add('active');
            }

            // تحميل منطقة محفوظة
            window.loadArea = function (areaId) {
                fetch(`/areas/${areaId}`)
                    .then(response => response.json())
                    .then(area => {
                        source.clear();
                        const coords = JSON.parse(area.coordinates);
                        const feature = new ol.Feature({
                            geometry: new ol.geom.Polygon(coords)
                        });
                        source.addFeature(feature);
                        map.getView().fit(feature.getGeometry(), { padding: [50, 50, 50, 50] });
                    });
            };




                        document.getElementById('search-button').addEventListener('click', function () {
                const query = document.getElementById('map-search').value.trim();
                if (!query) return;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const result = data[0]; // أول نتيجة
                            const lon = parseFloat(result.lon);
                            const lat = parseFloat(result.lat);

                            const view = map.getView();
                            const center = ol.proj.fromLonLat([lon, lat]);
                            view.animate({ center: center, zoom: 15, duration: 1000 });

                            // يمكنك إضافة نقطة على الخريطة
                            const marker = new ol.Feature({
                                geometry: new ol.geom.Point(center)
                            });
                            source.addFeature(marker);
                        } else {
                            alert("لم يتم العثور على نتائج");
                        }
                    })
                    .catch(error => {
                        console.error("Geo search error:", error);
                        alert("حدث خطأ أثناء البحث");
                    });
            });




            // تفعيل الأداة الافتراضية
            addInteraction('Polygon');



                Livewire.on('areaSaved', () => {
                    source.clear(); // يمسح كل الخطوط والأشكال من الخريطة
                });





            //     document.getElementById('search-button').addEventListener('click', function () {
            //     const name = document.getElementById('search-area').value.trim();
            //     if (!name) return;

            //     fetch(`/areas/search/${name}`)
            //         .then(res => res.json())
            //         .then(area => {
            //             if (!area || !area.coordinates) {
            //                 alert('المنطقة غير موجودة!');
            //                 return;
            //             }

            //             source.clear();
            //             const coords = JSON.parse(area.coordinates);

            //             const feature = new ol.Feature({
            //                 geometry: new ol.geom.Polygon(coords)
            //             });
            //             source.addFeature(feature);
            //             map.getView().fit(feature.getGeometry(), { padding: [50, 50, 50, 50] });
            //         });
            // });





        });// نهاية livewire:init
