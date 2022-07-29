# lwmbs-build

## 简介
> lwmbs的便捷构建工具，oauth登录后可自定义扩展进行构建micro与php [dixyes/lwmbs](https://github.com/dixyes/lwmbs)

### 流程
1. 通过github的oauth登录 授权权限：read:user public_repo
2. 勾选需要的扩展
3. 检测是否fork [dixyes/lwmbs](https://github.com/dixyes/lwmbs) 仓库，没有则进行fork
4. 检测workflows是否处于active状态，没有则active
5. 根据参数配置进行run workflows

### 技术栈
- php8.1+swow
- [hyperf3.0](https://github.com/hyperf/hyperf) swow服务，相关依赖可查看`composer.json`
- [php-github-api](https://github.com/KnpLabs/php-github-api) 快捷调用github的api

## 使用

### 1、申请github app
- https://github.com/settings/developers
- new oauth app 得到 `client_id`、`client_secret`、`redirect_uri`

### 2、项目配置

#### 环境变量

```
GITHUB_APP_CLIENT_ID
GITHUB_APP_CLIENT_SECRET
GITHUB_APP_REDIRECT_URI
```

### 3、启动
```shell
$ php index.php start
```

## docker部署

// todo

## hyperf-box 部署

1、下载应用
https://github.com/lihq1403/lwmbs-build/actions

2、创建配置文件 `~/.lwmbs-build/.env` 并填写好申请的github oauth app信息
```shell
$ mkdir ~/..lwmbs-build
$ cp .env.example ~/.lwmbs-build/.env
```

3、启动示例
```shell
$ ./lwmbs_build_8.1_x86_64_macos start
```