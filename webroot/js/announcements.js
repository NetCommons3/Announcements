/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Announcements Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce, $modal, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements',
                         function($scope, $sce, $modal, $modalStack) {

      /**
       * Announcements plugin view url
       *
       * @const
       */
      $scope.PLUGIN_INDEX_URL = '/announcements/announcements/';

      /**
       * Announcements edit url
       *
       * @const
       */
      $scope.PLUGIN_EDIT_URL = '/announcements/announcement_edit/';

      /**
       * Announcement
       *
       * @type {Object.<string>}
       */
      $scope.announcement = {};

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(frameId, announcement) {
        $scope.frameId = frameId;
        $scope.announcement = announcement;
      };

      /**
       * Show manage dialog
       *
       * @return {void}
       */
      $scope.showManage = function() {
        //既に開いているモーダルウィンドウをキャンセルする
        $modalStack.dismissAll('canceled');

        var templateUrl = $scope.PLUGIN_EDIT_URL +
                              'view/' + $scope.frameId + '.json';
        var controller = 'Announcements.edit';

        $modal.open({
          templateUrl: templateUrl,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        }).result.then(
            function(result) {
//$scope.$apply(function() {alert(1);});
            },
            function(reason) {
              if (typeof reason.data === 'object') {
                //openによるエラー
                $scope.flash.danger(reason.status + ' ' + reason.data.name);
              } else if (reason === 'canceled') {
                //キャンセル
                $scope.flash.close();
              }
            }
        );
      };

      /**
       * htmlContent method
       *
       * @return {string}
       */
      $scope.htmlContent = function() {
        //ng-bind-html では、style属性まで消えてしまうため
        return $sce.trustAsHtml($scope.announcement.Announcement.content);
      };

    });


/**
 * Announcements.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http, $modalStack)} Controller
 */
NetCommonsApp.controller('Announcements.edit',
                         function($scope, $http, $modalStack) {

      /**
       * paginator
       *
       * @type {Object.<string>}
       */
      $scope.paginator = {
        'current': 1,
        'hasPrev': false,
        'nextPrev': false
      };

      /**
       * comments
       *
       * @type {Object.<string>}
       */
      $scope.comments = [];
      $scope.commentHtml = '';

      /**
       * sending
       *
       * @type {string}
       */
      $scope.sending = false;

      /**
       * edit object
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {}
      };

      /**
       * dialog initialize
       *
       * @return {void}
       */
      $scope.initialize = function() {
        $scope.edit.data = {
          Announcement: {
            content: $scope.announcement.Announcement.content,
            comment: '',
            status: $scope.announcement.Announcement.status,
            block_id: $scope.announcement.Announcement.block_id,
            key: $scope.announcement.Announcement.key,
            id: $scope.announcement.Announcement.id
          },
          Frame: {
            id: $scope.frameId
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        };
      };
      // initialize()
      $scope.initialize();

      /**
       * prev page
       *
       * @return {void}
       */
      $scope.prevPage = function() {
        if (! $scope.paginator.hasPrev) {
          return;
        }
        $scope.movePage($scope.paginator.current - 1);
        // b$scope.$apply();
      };

      /**
       * next page
       *
       * @return {void}
       */
      $scope.nextPage = function() {
        if (! $scope.paginator.hasNext) {
          return;
        }
        $scope.movePage($scope.paginator.current + 1);
        //$scope.$apply();
      };

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.movePage = function(page) {
        //$scope.$apply(function() {
          $http.get($scope.PLUGIN_EDIT_URL + 'comment/' +
                     $scope.frameId + '/page:' + page + '.json')
               .success(function(data) {
                  $scope.paginator.current = data.current;
                  $scope.paginator.hasPrev = data.hasPrev;
                  $scope.paginator.hasNext = data.hasNext;
                  $scope.comments = data.comments;
//                  setTimeout(function() {
//                    $scope.$apply();
////                      $scope.$apply(function() {
////                          $scope.paginator.current = data.current;
////                          $scope.paginator.hasPrev = data.hasPrev;
////                          $scope.paginator.hasNext = data.hasNext;
////                          $scope.comments = data.comments;
////
////                          console.log($scope.comments);
////                      });
//                    }, 1000);
               })
               .error(function(data, status) {
                 //keyの取得に失敗
                 $scope.flash.danger(data.name);
               });
        //});
      };

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
      };

      /**
       * dialog save
       *
       * @param {number} status
       * - 1: Publish
       * - 2: Approve
       * - 3: Draft
       * - 4: Disapprove
       * @return {void}
       */
      $scope.save = function(status) {
        $scope.sending = true;

        $http.get($scope.PLUGIN_EDIT_URL + 'form/' +
                  $scope.frameId + '/' + Math.random() + '.json')
            .success(function(data) {
              //フォームエレメント生成
              var form = $('<div>').html(data);

              //セキュリティキーセット
              $scope.edit.data._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              $scope.edit.data._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              $scope.edit.data._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();

              //ステータスセット
              $scope.edit.data.Announcement.status = status;

              //登録情報をPOST
              $scope.sendPost($scope.edit);
            })
            .error(function(data, status) {
              //keyの取得に失敗
              $scope.flash.danger(status + ' ' + data.name);
              $scope.sending = false;
            });
      };

      /**
       * send post
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPost = function(postParams) {
        $http.post($scope.PLUGIN_EDIT_URL + 'edit/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.announcement, $scope.announcement);
              $scope.flash.success(data.name);
              $scope.sending = false;
              $modalStack.dismissAll('saved');
            })
          .error(function(data, status) {
              $scope.flash.danger(status + ' ' + data.name);
              $scope.sending = false;
            });
      };

    });
