/*global kakao*/
/* eslint-disable no-unused-vars */

/** @class kakao maps wrapping class. */
class Map {
    latitude;
    longitude;
    mapId;
    level;
    map;
    marker;

    /**
     * Creates an instance of kakao maps.
     *
     * @constructor
     * @param {number} latitude 위도
     * @param {number} longitude 경도
     * @param {string} mapId 지도 표시할 Element ID
     * @param {number} level 지도 확대 레벨
     */
    constructor(latitude, longitude, mapId = "map", level = 3) {
        /** @private */ this.latitude = latitude;
        /** @private */ this.longitude = longitude;
        /** @private */ this.mapId = mapId;
        /** @private */ this.level = level;

        this.init();
    }

    /**
     * 맵 초기화
     */
    init() {
        var container = document.getElementById(this.mapId);
        var options = {
            center: new kakao.maps.LatLng(this.latitude, this.longitude),
            level: this.level
        };
        this.map = new kakao.maps.Map(container, options);
        this.marker = new kakao.maps.Marker({
            position: this.map.getCenter()
        });
        this.marker.setMap(this.map);
    }

    /**
     * 맵 재설정
     */
    reset() {
        // 버튼을 클릭하면 아래 배열의 좌표들이 모두 보이게 지도 범위를 재설정합니다 
        var points = [
            new kakao.maps.LatLng(33.452278, 126.567803),
            new kakao.maps.LatLng(33.452671, 126.574792),
            new kakao.maps.LatLng(33.451744, 126.572441)
        ];
        // 지도를 재설정할 범위정보를 가지고 있을 LatLngBounds 객체를 생성합니다
        var bounds = new kakao.maps.LatLngBounds();
        var i, marker;
        for (i = 0; i < points.length; i++) {
            // 배열의 좌표들이 잘 보이게 마커를 지도에 추가합니다
            marker = new kakao.maps.Marker({ position: points[i] });
            marker.setMap(this.map);
            // LatLngBounds 객체에 좌표를 추가합니다
            bounds.extend(points[i]);
        }
        // LatLngBounds 객체에 추가된 좌표들을 기준으로 지도의 범위를 재설정합니다
        // 이때 지도의 중심좌표와 레벨이 변경될 수 있습니다
        this.map.setBounds(bounds);
    }

    /**
     * 맵 사이즈 재설정
     */
    resizeMap(width, height) {
        var mapContainer = document.getElementById(this.mapId);
        mapContainer.style.width = width;
        mapContainer.style.height = height;
        this.relayout();
    }

    relayout() {

        // 지도를 표시하는 div 크기를 변경한 이후 지도가 정상적으로 표출되지 않을 수도 있습니다
        // 크기를 변경한 이후에는 반드시  map.relayout 함수를 호출해야 합니다 
        // window의 resize 이벤트에 의한 크기변경은 map.relayout 함수가 자동으로 호출됩니다
        this.map.relayout();
    }

    /**
     * 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다. 지도 타입 컨트롤을 지도에 표시합니다.
     */
    addControlForMapType() {
        var mapTypeControl = new kakao.maps.MapTypeControl();
        this.map.addControl(mapTypeControl, kakao.maps.ControlPosition.TOPRIGHT);
    }

    /**
     * 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
     */
    addControlForZoom() {
        var zoomControl = new kakao.maps.ZoomControl();
        this.map.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);
    }

    /**
     * 지도에 교통정보를 표시하도록 지도타입을 추가합니다
     */
    addOverlayMapTypeId(type) {
        if (type === 'traffic') {
            this.map.addOverlayMapTypeId(kakao.maps.MapTypeId.TRAFFIC);
        }
        else if (type === 'roadview') {
            this.map.addOverlayMapTypeId(kakao.maps.MapTypeId.ROADVIEW);
        }
        else if (type === 'terrain') {
            this.map.addOverlayMapTypeId(kakao.maps.MapTypeId.TERRAIN);
        }
        else if (type === 'use_district') {
            this.map.addOverlayMapTypeId(kakao.maps.MapTypeId.USE_DISTRICT);
        }
    }

    /**
     * 지도에 교통정보를 표시하도록 지도타입을 제거합니다
     */
    removeOverlayMapTypeId(type) {
        if (type === 'traffic') {
            this.map.removeOverlayMapTypeId(kakao.maps.MapTypeId.TRAFFIC);
        }
        else if (type === 'roadview') {
            this.map.removeOverlayMapTypeId(kakao.maps.MapTypeId.ROADVIEW);
        }
        else if (type === 'terrain') {
            this.map.removeOverlayMapTypeId(kakao.maps.MapTypeId.TERRAIN);
        }
        else if (type === 'use_district') {
            this.map.removeOverlayMapTypeId(kakao.maps.MapTypeId.USE_DISTRICT);
        }
    }


    /**
     * 이동할 위도 경도 위치를 생성합니다. 지도 중심을 이동 시킵니다.
     */
    setCenter(latitude, longitude) {
        var moveLatLon = new kakao.maps.LatLng(latitude, longitude);
        this.map.setCenter(moveLatLon);
    }

    /**
     * 이동할 위도 경도 위치를 생성합니다. 지도 중심을 부드럽게 이동시킵니다. 만약 이동할 거리가 지도 화면보다 크면 부드러운 효과 없이 이동합니다.
     */
    panTo(latitude, longitude) {
        var moveLatLon = new kakao.maps.LatLng(latitude, longitude);
        this.map.panTo(moveLatLon);
    }

    /**
     * 지도 확대
     */
    zoomIn() {
        var level = this.map.getLevel();
        this.map.setLevel(level - 1);
    }

    /**
     * 지도 축소
     */
    zoomOut() {
        var level = this.map.getLevel();
        this.map.setLevel(level + 1);
    }

    /**
     * 지도 축소
     */
    setMapType(maptype) {
        if (maptype === 'roadmap') {
            this.map.setMapTypeId(kakao.maps.MapTypeId.ROADMAP);
        } else if (maptype === 'skyview') {
            this.map.setMapTypeId(kakao.maps.MapTypeId.HYBRID);
        }
    }

    /**
     * 버튼 클릭에 따라 지도 이동 기능을 막거나 풀고 싶은 경우에는 map.setDraggable 함수를 사용합니다
     */
    setDraggable(draggable) {
        // 마우스 드래그로 지도 이동 가능여부를 설정합니다
        this.map.setDraggable(draggable);
    }

    /**
     * 버튼 클릭에 따라 지도 확대, 축소 기능을 막거나 풀고 싶은 경우에는 map.setZoomable 함수를 사용합니다
     */
    setZoomable(zoomable) {
        // 마우스 휠로 지도 확대,축소 가능여부를 설정합니다
        this.map.setZoomable(zoomable);
    }

    /**
     * 현재 지도의 각종 정보 
     */
    getInfo() {
        var info = new MapInfo(this.map);
        console.log(info.message);
        return info;
    }
}

class MapInfo {
    map;
    center;
    level;
    mapTypeId;
    bounds;
    swLatLng;
    neLatLng;
    boundsStr;
    message;

    /**
     * Creates an instance of kakao maps.
     *
     * @constructor
     * @param {number} latitude 위도
     * @param {number} longitude 경도
     * @param {string} mapId 지도 표시할 Element ID
     * @param {number} level 지도 확대 레벨
     */
    constructor(map) {
        /** @private */ this.map = map;
        this.center = this.map.getCenter();// 지도의 현재 중심좌표를 얻어옵니다 
        this.level = this.map.getLevel();// 지도의 현재 레벨을 얻어옵니다
        this.mapTypeId = this.map.getMapTypeId();// 지도타입을 얻어옵니다
        this.bounds = this.map.getBounds();// 지도의 현재 영역을 얻어옵니다 
        this.swLatLng = this.bounds.getSouthWest();// 영역의 남서쪽 좌표를 얻어옵니다 
        this.neLatLng = this.bounds.getNorthEast();// 영역의 북동쪽 좌표를 얻어옵니다 
        this.boundsStr = this.bounds.toString();// 영역정보를 문자열로 얻어옵니다. ((남,서), (북,동)) 형식입니다
        this.message = '지도 중심좌표는 위도 ' + this.center.getLat() + ', \n'
            + '경도 ' + this.center.getLng() + ' 이고 \n'
            + '지도 레벨은 ' + this.level + ' 입니다 \n\n'
            + '지도 타입은 ' + this.mapTypeId + ' 이고 \n '
            + '지도의 남서쪽 좌표는 ' + this.swLatLng.getLat() + ', ' + this.swLatLng.getLng() + ' 이고 \n'
            + '북동쪽 좌표는 ' + this.neLatLng.getLat() + ', ' + this.neLatLng.getLng() + ' 입니다';
    }
}

