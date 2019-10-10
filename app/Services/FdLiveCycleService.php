<?php
namespace App\Services;
/**
 * Fd 生命周期
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18 0018
 * Time: 22:29
 */
class FdLiveCycleService {

    /**
     * UserId与FD绑定
     * @param $userId
     * @param $fd
     */
    public function setFd($userId, $fd)
    {
        app('swoole')->wsTable->set('uid:' . $userId, ['value' => $fd]);// 绑定uid到fd的映射
        app('swoole')->wsTable->set('fd:' . $fd, ['value' => $userId]);// 绑定fd到uid的映射
    }

    /**
     * 广播
     * @param $server
     */
    public function broadcastFd($server)
    {
        foreach (app('swoole')->wsTable as $key => $row) {
            if (strpos($key, 'uid:') === 0 && $server->exist($row['value'])) {
                $server->push($row['value'], 'Broadcast: ' . date('Y-m-d H:i:s'));// 广播
            }
        }
    }

    /**
     * 关闭绑定
     * @param $fd
     */
    public function delFd($fd)
    {
        $uid = app('swoole')->wsTable->get('fd:' . $fd);
        if ($uid !== false) {
            app('swoole')->wsTable->del('uid:' . $uid['value']);// 解绑uid映射
        }
        app('swoole')->wsTable->del('fd:' . $fd);// 解绑fd映射
    }

    /**
     * 获取Fd通过uid 并判断是不是有效的连接
     * @param $uid
     * @return string
     */
    public static function getFdToUid($uid)
    {
        $uid = app('swoole')->wsTable->get('uid:' . $uid);
        if ($uid !== false) {
            $fd = $uid['value'];
            // 连接是否为有效的WebSocket客户端连接
            if (app('swoole')->isEstablished($fd)) {
                return $fd;
            }
            return '';
        }
        return '';
    }
}
