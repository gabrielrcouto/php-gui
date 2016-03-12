# PHP GUI

## Flow

PHP <=> Stdin/Stdout Pipes <=> Lazarus Application <=> GUI

## Protocol

Based on JSON RPC:

### Request:

```json
{
	"id": 2,
	"method": "creatObject",
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