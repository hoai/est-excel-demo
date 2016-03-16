# 说明

[maatwebsite/excel](https://github.com/Maatwebsite/Laravel-Excel) 是一款强大的 Excel 文件处理扩展包, 使用它能非常快速的完成常用的解析/导出 Excel 功能.

> 本项目由 [The EST Group](http://est-group.org/) 团队整理发布, 首发地为 [PHPHub 社区](https://phphub.org/), 关于 PHPHub 社区往期的开源作品可 [在此](https://phphub.org/topics/1531) 查看.

## 具体安装说明

请访问此地址: 

## 安装

本项目使用 [Laravel](https://laravel.com/docs/5.2) ( [中文文档见此](http://laravel-china.org/docs/5.0) ), 本地开发环境使用 [Homestead](http://laravel-china.org/docs/5.0/homestead) 进行快速部署. 
下文将在默认读者已经安装好 `Homestead` 情况下进行说明.

### 1. 克隆代码

    https://github.com/zhengjinghua/est-excel-demo.git

### 2. 配置本地的 homestead 环境

编辑文件:

    homestead edit

对应加入修改:

    folders:
        - map: /Users/.../est-excel-demo {你的本地项目地址}
          to: /home/vagrant/est-excel-demo

    sites:
        - map: image.app
          to: /home/vagrant/est-excel-demo/public

    databases:
        - excel

应用修改:

    homestead provision

### 3. 安装依赖

    composer install
   
### 4. 生成配置文件

复制 `.env.example` 为 `.env`

```
cp .env.example .env
```

由于此项目没有使用其他复杂的逻辑, 因此无需做其他额外的配置

### 5. 修改 hosts

	sudo vi /etc/hosts

添加

	192.168.10.10  	excel.app
	
配置完以后浏览器直接访问 http://excel.app 即可


