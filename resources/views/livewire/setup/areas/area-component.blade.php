<div>
    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.3.0/ol.css">
        <style>
            #map {
                        width: 100%;
                        height: 500px;
                        border: 1px solid #ccc;
                    }
                    .toolbar {
                        margin: 10px 0;
                        display: flex;
                        gap: 10px;
                    }
                    .toolbar button {
                        padding: 8px 15px;
                        background: #4a5568;
                        color: white;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }
                    .toolbar button.active {
                        background: #2d3748;
                    }
                    .form-group {
                        margin: 15px 0;
                    }
                    .alert {
                        padding: 10px;
                        margin: 10px 0;
                    }
        </style>
    @endsection
    @section('title', __('Areas'))
    <div class="card">
        <div class="card-header ">
            <h4 class="text-center">  {{ __('Areas') }}</h4>

        </div>
        <div class="card-body">

    {{-- فورم البحث --}}
    <div class="form-group">
        <label for="search">بحث عن منطقة</label>
        <input type="text" id="map-search" placeholder="ابحث عن مكان..." class="form-control mt-3">
        <button id="search-button" class="btn btn-primary mt-2">بحث</button>
    </div>

    <hr>
    <!-- نموذج اسم المنطقة -->
    <div class="form-group">
        <label>اسم المنطقة</label>
        <input type="text" wire:model="name" class="form-control">
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

        <input type="hidden" wire:model="coordinates" name="coordinates" id="coord-input">

    </div>

    <button wire:click.prevent="saveArea" class="btn btn-primary">حفظ المنطقة ✔️</button>

<hr>

              <!-- أدوات الرسم -->
    <div class="toolbar">
        <button id="draw-polygon" class="active">مضلع</button>
        <button id="draw-rectangle">مستطيل</button>
        <button id="draw-circle">دائرة</button>
        <button id="draw-line">خط</button>
        <button id="clear-all">مسح الكل</button>
    </div>
    <!-- الخريطة -->
        <div id="map" wire:ignore></div>

        <div class="card-footer">
              <!-- قائمة المناطق المحفوظة -->
            <div class="saved-areas" style="margin-top: 20px;">
                <h3>المناطق المتاحة:</h3>
                <ul class="list-group">
                    @foreach($areas as $area)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $area->name }}
                            <button class="btn btn-primary" onclick="loadArea({{ $area->id }})">عرض</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>



    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.3.0/dist/ol.js"></script>

    <script src="{{ asset('js/areas.js') }}"></script>
    {{-- <script>
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

            // تفعيل الأداة الافتراضية
            addInteraction('Polygon');



                Livewire.on('areaSaved', () => {
                    source.clear(); // يمسح كل الخطوط والأشكال من الخريطة
                });
        });
    </script> --}}

    @endsection
</div>
@script
    @include('tools.message')
@endscript
