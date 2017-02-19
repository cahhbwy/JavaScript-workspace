#浏览器定位&ip定位
###需要post的数据
>	canLocation	y/n		//是否可以浏览器定位

>	longitude			//经度

>	latitude			//纬度

>	accuracy			//精度

>	locPosition			//根据经纬度定位的地点


###php接收的数据
>	ip					//从POST头中获取IP地址

>	//上面发送的四个数据

>	canLocation	y/n		//是否可以浏览器定位

>	longitude			//经度

>	latitude			//纬度

>	accuracy			//精度

>	locPosition			//根据经纬度定位的地点

>	//要计算的一些数据

>	ipPositon			//根据IP定位得到的地理位置

	
接收的以上数据，需要向数据库里插入