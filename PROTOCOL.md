# IPC Protocol

This file describes the IPC protocol used for the PHP <-> Lazarus communication.

This protocol is based on JSON RPC.

## Request (Command):

```json
{
    "id": 2,
    "method": "createObject",
    "params": [
        {
            "lazarusClass": "TButton",
            "lazarusObjectId": 1,
            "parent": 0
        }
    ]
}
```

## Response:

```json
{
    "id": 2,
    "result": 123
}
```

## Notification (Event):

```json
{
    "method": "eventCallback",
    "params": [
        {
            "name": "Click",
            "target": 123
        }
    ]
}
```

## Commands avaible:

### createObject

Request:

```json
{
    "id": 2,
    "method": "createObject",
    "params": [
        {
            "lazarusClass": "TButton",
            "lazarusObjectId": 123,
            "parent": 0
        }
    ]
}
```

Response:

```json
{
    "id": 2,
    "result": 123 // This is the object ID
}
```

### setObjectProperty

```json
{
    "id": 2,
    "method": "setObjectProperty",
    "params": [
        lazarusObjectId,
        "propertyName",
        "propertyValue"
    ]
}
```

Response:

```json
{
    "id": 2,
    "result": true
}
```

### setObjectEventListener

```json
{
    "id": 2,
    "method": "setObjectEventListener",
    "params": [
        lazarusObjectId,
        "eventName"
    ]
}
```

Response:

```json
{
    "id": 2,
    "result": true
}
```

### getObjectProperty

```json
{
    "callback":false,
    "id":134,
    "method":"getObjectProperty",
    "params":[
        14,
        "itemIndex"
    ]
}
```

Response:

```json
{
    "id": 134,
    "result": 1
}
```

### callObjectMethod

```json
{
    "callback":{},
    "id":19,
    "method":"callObjectMethod",
    "params":[
        14,
        "items.addObject",
        [
            "Male",
            0
        ]
    ]
}
```

Response:

```json
{
    "id": 19,
    "result": 14
}
```

### Debug

if you want debug something from lazarus you can use the key "debug" like 

```
{
    "callback" : {},
    "id" : 94,
    "method" : "setObjectProperty",
    "params" : [
        18,
        "caption",
        "test"
    ],
    "debug" : true
}
```