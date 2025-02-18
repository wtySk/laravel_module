<?php

const HTTP_OK = 200; // 请求已成功，请求所希望的响应头或数据体将随此响应返回。实际的响应将取决于所使用的请求方法。在GET请求中，响应将包含与请求的资源相对应的实体。在POST请求中，响应将包含描述或操作结果的实体。
const HTTP_CREATED = 201; // 请求已经被实现，而且有一个新的资源已经依据请求的需要而建立，且其URI已经随Location头信息返回。假如需要的资源无法及时建立的话，应当返回'202 Accepted'。
const HTTP_ACCEPTED = 202; // 服务器已接受请求，但尚未处理。最终该请求可能会也可能不会被执行，并且可能在处理發生时被禁止。
const HTTP_NO_CONTENT = 204; // 服务器成功处理了请求，没有返回任何内容。
const HTTP_RESET_CONTENT = 205; // 服务器成功处理了请求，但没有返回任何内容。与204响应不同，此响应要求请求者重置文档视图。
const HTTP_BAD_REQUEST = 400; // 由于明显的客户端错误（例如，格式错误的请求语法，太大的大小，无效的请求消息或欺骗性路由请求），服务器不能或不会处理该请求。
const HTTP_UNAUTHORIZED = 401; // 未认证 或 认证失败 跟 403 不同， 403 是没有权限
const HTTP_FORBIDDEN = 403; // 没有权限
const HTTP_NOT_FOUND = 404; // 请求失败
const HTTP_METHOD_NOT_ALLOWED = 405; // 请求的方法不允许
const HTTP_REQUEST_TIMEOUT = 408; // 请求超时
const HTTP_CONFLICT = 409; // 请求冲突
const HTTP_GONE = 410; // 资源已删除
const HTTP_REQUEST_ENTITY_TOO_LARGE = 413; // 提交内容过大
const HTTP_LOCKED = 423; // 资源被锁定
const HTTP_TOO_MANY_REQUESTS = 429; // 请求过多
const HTTP_SERVICE_ERROR = 500; // 通用错误消息，服务器遇到了一个未曾预料的状况，导致了它无法完成对请求的处理。没有给出具体错误信息。
const HTTP_NOT_IMPLEMENTED = 501; // 服务器不支持当前请求所需要的某个功能。当服务器无法识别请求的方法，并且无法支持其对任何资源的请求。
const HTTP_BAD_GATEWAY = 502; // 作为网关或者代理工作的服务器尝试执行请求时，从上游服务器接收到无效的响应。
const HTTP_SERVICE_UNAVAILABLE = 503; // 由于临时的服务器维护或者过载，服务器当前无法处理请求。这个状况是暂时的，并且将在一段时间以后恢复。
const HTTP_GATEWAY_TIMEOUT = 504; // 作为网关或者代理工作的服务器尝试执行请求时，未能及时从上游服务器（URI标识出的服务器，例如HTTP、FTP、LDAP）或者辅助服务器（例如DNS）收到响应。
const HTTP_NOT_EXTENDED = 510; // 获取资源所需要的策略并没有被满足。
