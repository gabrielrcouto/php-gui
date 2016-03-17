# PHP GUI

## Flow

PHP <=> Stdin/Stdout Pipes <=> Lazarus Application <=> GUI

## Protocol

Based on JSON RPC:

### Request/Command:

```json
{
	"id": 2,
	"method": "createObject",
	"params": [
		{
			"lazarusClass": "TButton"
		}
	]
}
```

### Response:

```json
{
	"id": 2,
	"result": 123
}
```

### Notification/Event:

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

### Commands avaible:

#### createObject

Request:

```json
{
	"id": 2,
	"method": "createObject",
	"params": [
		{
			"lazarusClass": "TButton",
			"lazarusObjectId": 123
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

#### setObjectProperty

```json
{
	"id": 2,
	"method": "setObjectProperty",
	"params": [
		objectId,
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

#### setObjectEventListener

```json
{
	"id": 2,
	"method": "setObjectEventListener",
	"params": [
		objectId,
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

## Compiling Lazarus App

```bash
lazbuild phpgui.lpr
```