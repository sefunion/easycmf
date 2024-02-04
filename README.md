## 项目介绍

PHP有很多优秀的后台管理系统，但基于Swoole的后台管理系统没找到合适我自己的。
所以就开发了一套后台管理系统。系统可以用于网站管理后台、CMS、CRM、OA、ERP等。

后台系统基于 Hyperf 框架开发。企业级架构分层，轻松支撑创业公司及个人前期发展使用，使用少量的服务器资源媲美静态语言的性能。
前端使用Vue3 + Vite4 + Pinia + Arco，一端适配PC、移动端、平板


## 前端仓库地址
移步前端仓库

- [Github EasyCMF-Vue](https://github.com/sefunion/EasyCMF-Vue)
- [Gitee EasyCMF-Vue](https://gitee.com/sefunion/EasyCMF-vue)


## 内置功能

1.  用户管理，完成用户添加、修改、删除配置，支持不同用户登录后台看到不同的首页
2.  部门管理，部门组织机构（公司、部门、小组），树结构展现支持数据权限
3.  岗位管理，可以给用户配置所担任职务
4.  角色管理，角色菜单权限分配、角色数据权限分配
5.  菜单管理，配置系统菜单和按钮等
6.  字典管理，对系统中经常使用并且固定的数据可以重复使用和维护
7.  系统配置，系统的一些常用设置管理
8.  操作日志，用户对系统的一些正常操作的查询
9.  登录日志，用户登录系统的记录查询
10. 在线用户，查看当前登录的用户
11. 服务监控，查看当前服务器状态和PHP环境等信息
12. 附件管理，管理当前系统上传的文件及图片等信息
13. 数据表维护，对系统的数据表可以进行清理碎片和优化
14. 模块管理，管理系统当前所有模块
15. 定时任务，在线（添加、修改、删除)任务调度包含执行结果日志
16. 代码生成，前后端代码的生成（php、vue、js、sql），支持下载和生成到模块
17. 缓存监控，查看Redis信息和系统所使用key的信息
18. API管理，对应用和接口管理、接口授权等功能。接口文档自动生成，输入、输出参数检查等
19. 队列管理，消息队列管理功能、消息管理、消息发送。使用ws方式即时消息提醒（需安装rabbitMQ）
20. 应用市场，可下载各种基础应用、插件、前端组件等等（开发中...）

## 环境需求

- Swoole >= 5.0 并关闭 `Short Name`
- PHP >= 8.1 并开启以下扩展：
  - mbstring
  - json
  - pdo
  - openssl
  - redis
  - pcntl
- Mysql >= 5.7
- Redis >= 4.0
- Git >= 2.x


## 下载项目
- EasyCMF没有使用SQL文件导入安装，系统使用Migrates迁移文件形式安装和填充数据，请知悉。

- 项目下载，请确保已经安装了 `Composer`
```shell
git clone https://gitee.com/sefunion/EasyCMF && cd EasyCMF
composer config -g repo.packagist composer https://mirrors.tencent.com/composer/
composer install
```

## 项目安装

打开终端，执行安装命令，按照提示，一步步完成`.env`文件的配置
```shell
php bin/hyperf.php easy:install
```

待提示以下信息后
```shell
Reset the ".env" file. Please restart the service before running 
the installation command to continue the installation.
```

再次执行安装命令，执行Migrates数据迁移文件和SQL数据填充，完成安装。
```shell
php bin/hyperf.php easy:install
```
