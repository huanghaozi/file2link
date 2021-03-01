# file2link
PHP利用Github与jsdelivr生成文件直链（对象存储/图床）

[Demo](https://huanghaozi.cn/tools/file2link/uploader.html)

芜湖，用Vue重构基本完成！

# 食用方法
1. 在[这个页面](https://github.com/settings/tokens)创建一个token，记录下来
2. 在Github创建一个Repository
3. 修改 **api_func.php** 中用户名、Repo名、分支名、TOKEN
4. 部署，芜湖，起飞

# 注意事项
- 来自[wangyaojiu](https://github.com/huanghaozi/file2link/issues/2#issuecomment-787230842)
> 我发现了个新的问题就是记得修改Nginx缓冲区大小 传递的参数超过接受参数的大小,会出现异常，client_body_buffer_size的值调整为51000K（jd cdn加速的最大限制是50m）这样就不会出错啦
