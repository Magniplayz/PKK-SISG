<?php

namespace App\Validator;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class NisnValidator
{
    public function validateNisn($attribute, $value, $parameters, $validator)
    {
        $values = [
            'ctl00$contentCenter$edNISN' => $value,
            'ctl00$contentCenter$edIbu' => $validator->getData()[$parameters[0]],
            '__VIEWSTATE' => '/wEPDwUKLTgyNzQ2MjQ4Nw9kFgJmD2QWAgIDD2QWCAIFDw8WBB4VRW5hYmxlRW1iZWRkZWRTY3JpcHRzZx4cRW5hYmxlRW1iZWRkZWRCYXNlU3R5bGVzaGVldGdkZAIJDxQrAAIUKwACDxYQHhFEYXRhRmllbGRQYXJlbnRJRAUIcGFyZW50SUQeC18hRGF0YUJvdW5kZx4ORGF0YVZhbHVlRmllbGQFBml0ZW1JRB8AZx4NRGF0YVRleHRGaWVsZAUIaXRlbVRleHQfAWceC0RhdGFGaWVsZElEBQZpdGVtSUQeElJlc29sdmVkUmVuZGVyTW9kZQspclRlbGVyaWsuV2ViLlVJLlJlbmRlck1vZGUsIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTkuMS4xMTUuNDAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNAFkDxQrAAYUKwACDxYEHgRUZXh0BQdCZXJhbmRhHgVWYWx1ZQUBMWRkFCsAAg8WBB8IBRJBdHVyYW4gJiBLZWJpamFrYW4fCQUBM2RkFCsAAg8WBB8IBR9NZWthbmlzbWUgUGVuZXJiaXRhbjxiciAvPiBOSVNOHwkFATRkZBQrAAIPFgQfCAUKRGF0YSBTaXN3YR8JBQE1ZGQUKwACDxYEHwgFC0tvbnRhayBLYW1pHwkFATdkZBQrAAIPFgQfCAUDRkFRHwkFAThkZA8UKwEGZmZmZmZmFgEFc1RlbGVyaWsuV2ViLlVJLlJhZE1lbnVJdGVtLCBUZWxlcmlrLldlYi5VSSwgVmVyc2lvbj0yMDE5LjEuMTE1LjQwLCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTEyMWZhZTc4MTY1YmEzZDRkFgxmDw8WBB8IBQdCZXJhbmRhHwkFATFkZAIBDw8WBB8IBRJBdHVyYW4gJiBLZWJpamFrYW4fCQUBM2RkAgIPDxYEHwgFH01la2FuaXNtZSBQZW5lcmJpdGFuPGJyIC8+IE5JU04fCQUBNGRkAgMPDxYEHwgFCkRhdGEgU2lzd2EfCQUBNWRkAgQPDxYEHwgFC0tvbnRhayBLYW1pHwkFATdkZAIFDw8WBB8IBQNGQVEfCQUBOGRkAgsPZBYCAgEPZBYEAgEPFCsAAhQrAAIPFgYfAGcfAWcfBwsrBAFkEBYCZgIBFgIUKwACDxYCHhJJbXBsaWNpdFBhZ2VWaWV3SUQFBHB2UzFkZBQrAAIPFgIfCgUEcHZTMmRkDxYCZmYWAQVuVGVsZXJpay5XZWIuVUkuUmFkVGFiLCBUZWxlcmlrLldlYi5VSSwgVmVyc2lvbj0yMDE5LjEuMTE1LjQwLCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTEyMWZhZTc4MTY1YmEzZDRkFgRmDw8WAh8KBQRwdlMxZGQCAQ8PFgIfCgUEcHZTMmRkAgMPFCsAAg8WCB4NU2VsZWN0ZWRJbmRleGYfAGcfAWcfBwsrBAFkFQQEcHZTMQRwdlMyBnB2UmVzMQZwdlJlczIWBmYPZBYCAgEPZBYGAgEPDxYEHghDc3NDbGFzcwU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FbmFibGVkX0RlZmF1bHQeBF8hU0ICAhYKHgtvbm1vdXNlb3ZlcgUjamF2YXNjcmlwdDokcmFkSUUubW91c2VPdmVyKGV2ZW50KTseCm9ubW91c2VvdXQFImphdmFzY3JpcHQ6JHJhZElFLm1vdXNlT3V0KGV2ZW50KTseCm9ua2V5cHJlc3MFImphdmFzY3JpcHQ6JHJhZElFLmtleVByZXNzKGV2ZW50KTseBm9uYmx1cgUeamF2YXNjcmlwdDokcmFkSUUuYmx1cihldmVudCk7HgdvbmZvY3VzBR9qYXZhc2NyaXB0OiRyYWRJRS5mb2N1cyhldmVudCk7ZAIDDw8WBB8MBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VuYWJsZWRfRGVmYXVsdB8NAgIWCh8OBSNqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU92ZXIoZXZlbnQpOx8PBSJqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU91dChldmVudCk7HxAFImphdmFzY3JpcHQ6JHJhZElFLmtleVByZXNzKGV2ZW50KTsfEQUeamF2YXNjcmlwdDokcmFkSUUuYmx1cihldmVudCk7HxIFH2phdmFzY3JpcHQ6JHJhZElFLmZvY3VzKGV2ZW50KTtkAgUPPCsABAEADxYGHwBnHwFnHwcLKwQBZGQCAQ9kFgoCAQ8PFgQfDAU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FbmFibGVkX0RlZmF1bHQfDQICFgofDgUjamF2YXNjcmlwdDokcmFkSUUubW91c2VPdmVyKGV2ZW50KTsfDwUiamF2YXNjcmlwdDokcmFkSUUubW91c2VPdXQoZXZlbnQpOx8QBSJqYXZhc2NyaXB0OiRyYWRJRS5rZXlQcmVzcyhldmVudCk7HxEFHmphdmFzY3JpcHQ6JHJhZElFLmJsdXIoZXZlbnQpOx8SBR9qYXZhc2NyaXB0OiRyYWRJRS5mb2N1cyhldmVudCk7ZAIDDw8WBB8MBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VuYWJsZWRfRGVmYXVsdB8NAgIWCh8OBSNqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU92ZXIoZXZlbnQpOx8PBSJqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU91dChldmVudCk7HxAFImphdmFzY3JpcHQ6JHJhZElFLmtleVByZXNzKGV2ZW50KTsfEQUeamF2YXNjcmlwdDokcmFkSUUuYmx1cihldmVudCk7HxIFH2phdmFzY3JpcHQ6JHJhZElFLmZvY3VzKGV2ZW50KTtkAgUPDxYGHwFnHwBnHwcLKwQBZBYEZg8UKwAIDxYOHwhkHwBnHhFFbmFibGVBcmlhU3VwcG9ydGgeDUxhYmVsQ3NzQ2xhc3MFB3JpTGFiZWwfAWceBFNraW4FB0RlZmF1bHQfBwsrBAFkFgoeCUZvbnRfU2l6ZSgqIlN5c3RlbS5XZWIuVUkuV2ViQ29udHJvbHMuRm9udFVuaXQFMS4yZW0eBVdpZHRoGwAAAAAAAFlABwAAAB4KUmVzaXplTW9kZQspclRlbGVyaWsuV2ViLlVJLlJlc2l6ZU1vZGUsIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTkuMS4xMTUuNDAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNAAfDAURcmlUZXh0Qm94IHJpSG92ZXIfDQKCChYKHxYoKwUFMS4yZW0fFxsAAAAAAABZQAcAAAAfGAsrBgAfDAURcmlUZXh0Qm94IHJpRXJyb3IfDQKCChYKHxYoKwUFMS4yZW0fFxsAAAAAAABZQAcAAAAfGAsrBgAfDAUTcmlUZXh0Qm94IHJpRm9jdXNlZB8NAoIKFggfFigrBQUxLjJlbR8XGwAAAAAAAFlABwAAAB8MBRNyaVRleHRCb3ggcmlFbmFibGVkHw0CggoWCh8WKCsFBTEuMmVtHxcbAAAAAAAAWUAHAAAAHxgLKwYAHwwFFHJpVGV4dEJveCByaURpc2FibGVkHw0CggoWCh8WKCsFBTEuMmVtHxcbAAAAAAAAWUAHAAAAHxgLKwYAHwwFEXJpVGV4dEJveCByaUVtcHR5Hw0CggoWCh8WKCsFBTEuMmVtHxcbAAAAAAAAWUAHAAAAHxgLKwYAHwwFEHJpVGV4dEJveCByaVJlYWQfDQKCCmQCAg8UKwANDxYSBQ1TZWxlY3RlZERhdGVzDwWPAVRlbGVyaWsuV2ViLlVJLkNhbGVuZGFyLkNvbGxlY3Rpb25zLkRhdGVUaW1lQ29sbGVjdGlvbiwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxOS4xLjExNS40MCwgQ3VsdHVyZT1uZXV0cmFsLCBQdWJsaWNLZXlUb2tlbj0xMjFmYWU3ODE2NWJhM2Q0FCsAAAUETWF4RAYAwNkQ4OLjCAUNQ3VsdHVyZU5hbWVJRAUFaWQtSUQFC1NwZWNpYWxEYXlzDwWSAVRlbGVyaWsuV2ViLlVJLkNhbGVuZGFyLkNvbGxlY3Rpb25zLkNhbGVuZGFyRGF5Q29sbGVjdGlvbiwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxOS4xLjExNS40MCwgQ3VsdHVyZT1uZXV0cmFsLCBQdWJsaWNLZXlUb2tlbj0xMjFmYWU3ODE2NWJhM2Q0FCsAAAURRW5hYmxlTXVsdGlTZWxlY3RoBQ9SZW5kZXJJbnZpc2libGVnBQ1DdWx0dXJlSW5mb0lEKCltU3lzdGVtLkdsb2JhbGl6YXRpb24uQ3VsdHVyZUluZm8sIG1zY29ybGliLCBWZXJzaW9uPTQuMC4wLjAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49Yjc3YTVjNTYxOTM0ZTA4OQVpZC1JRAUJQ3VsdHVyZUlEAqEIBRBWaWV3U2VsZWN0b3JUZXh0BQF4DxYKHwBnHwFnHxNoHxUFB0RlZmF1bHQfBwsrBAFkZBYEHwwFC3JjTWFpblRhYmxlHw0CAhYEHwwFDHJjT3RoZXJNb250aB8NAgJkFgQfDAUKcmNTZWxlY3RlZB8NAgJkFgQfDAUKcmNEaXNhYmxlZB8NAgIWBB8MBQxyY091dE9mUmFuZ2UfDQICFgQfDAUJcmNXZWVrZW5kHw0CAhYEHwwFB3JjSG92ZXIfDQICFgQfDAUxUmFkQ2FsZW5kYXJNb250aFZpZXcgUmFkQ2FsZW5kYXJNb250aFZpZXdfRGVmYXVsdB8NAgIWBB8MBQlyY1ZpZXdTZWwfDQICZAIHDw8WBB8MBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VuYWJsZWRfRGVmYXVsdB8NAgIWCh8OBSNqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU92ZXIoZXZlbnQpOx8PBSJqYXZhc2NyaXB0OiRyYWRJRS5tb3VzZU91dChldmVudCk7HxAFImphdmFzY3JpcHQ6JHJhZElFLmtleVByZXNzKGV2ZW50KTsfEQUeamF2YXNjcmlwdDokcmFkSUUuYmx1cihldmVudCk7HxIFH2phdmFzY3JpcHQ6JHJhZElFLmZvY3VzKGV2ZW50KTtkAgkPPCsABAEADxYGHwBnHwFnHwcLKwQBZGQCAw9kFgICAw88KwAOAgAUKwACDxYGHwcLKwQBHwBnHwFnZBcCBQtFZGl0SW5kZXhlcxYABQ9TZWxlY3RlZEluZGV4ZXMWAAEWAhYLDwIFFCsABRQrAAUWAh4Eb2luZAICZGRkBQZjb2x1bW4UKwAFFgIfGQIDZGRkBQdjb2x1bW4xFCsABRYCHxkCBGRkZAUHY29sdW1uMhQrAAUWAh8ZAgVkZGQFB2NvbHVtbjMUKwAFFgIfGQIGZGRkBQdjb2x1bW41ZGUUKwAACyl5VGVsZXJpay5XZWIuVUkuR3JpZENoaWxkTG9hZE1vZGUsIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTkuMS4xMTUuNDAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNAE8KwAHAAspdFRlbGVyaWsuV2ViLlVJLkdyaWRFZGl0TW9kZSwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxOS4xLjExNS40MCwgQ3VsdHVyZT1uZXV0cmFsLCBQdWJsaWNLZXlUb2tlbj0xMjFmYWU3ODE2NWJhM2Q0ARYCHgRfZWZzFgQeE2NzX3BvcHVwc19DbG9zZVRleHQFBUNsb3NlHgRfZWNjZGRkZGZkAg0PZBYCAgEPFCsAAhYCHwcLKwQBEBYGZgIBAgICAwIEAgUWBhQrAAEWDh4QUmVhZE9ubHlDc3NDbGFzcwU1UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9SZWFkX0RlZmF1bHQeD0ZvY3VzZWRDc3NDbGFzcwU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9Gb2N1c2VkX0RlZmF1bHQeFEVtcHR5TWVzc2FnZUNzc0NsYXNzBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VtcHR5X0RlZmF1bHQeD0hvdmVyZWRDc3NDbGFzcwU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9Ib3Zlcl9EZWZhdWx0Hg9JbnZhbGlkQ3NzQ2xhc3MFNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRXJyb3JfRGVmYXVsdB4QRGlzYWJsZWRDc3NDbGFzcwU5UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9EaXNhYmxlZF9EZWZhdWx0Hg9FbmFibGVkQ3NzQ2xhc3MFOFJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRW5hYmxlZF9EZWZhdWx0FCsAARYOHx0FNVJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfUmVhZF9EZWZhdWx0Hx4FOFJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRm9jdXNlZF9EZWZhdWx0Hx8FNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRW1wdHlfRGVmYXVsdB8gBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0hvdmVyX0RlZmF1bHQfIQU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FcnJvcl9EZWZhdWx0HyIFOVJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRGlzYWJsZWRfRGVmYXVsdB8jBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VuYWJsZWRfRGVmYXVsdBQrAAEWDh8dBTVSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X1JlYWRfRGVmYXVsdB8eBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0ZvY3VzZWRfRGVmYXVsdB8fBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VtcHR5X0RlZmF1bHQfIAU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9Ib3Zlcl9EZWZhdWx0HyEFNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRXJyb3JfRGVmYXVsdB8iBTlSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0Rpc2FibGVkX0RlZmF1bHQfIwU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FbmFibGVkX0RlZmF1bHQUKwABFg4fHQU1UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9SZWFkX0RlZmF1bHQfHgU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9Gb2N1c2VkX0RlZmF1bHQfHwU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FbXB0eV9EZWZhdWx0HyAFNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfSG92ZXJfRGVmYXVsdB8hBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0Vycm9yX0RlZmF1bHQfIgU5UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9EaXNhYmxlZF9EZWZhdWx0HyMFOFJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRW5hYmxlZF9EZWZhdWx0FCsAARYOHx0FNVJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfUmVhZF9EZWZhdWx0Hx4FOFJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRm9jdXNlZF9EZWZhdWx0Hx8FNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRW1wdHlfRGVmYXVsdB8gBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0hvdmVyX0RlZmF1bHQfIQU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FcnJvcl9EZWZhdWx0HyIFOVJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRGlzYWJsZWRfRGVmYXVsdB8jBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VuYWJsZWRfRGVmYXVsdBQrAAEWDh8dBTVSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X1JlYWRfRGVmYXVsdB8eBThSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0ZvY3VzZWRfRGVmYXVsdB8fBTZSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0VtcHR5X0RlZmF1bHQfIAU2UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9Ib3Zlcl9EZWZhdWx0HyEFNlJhZElucHV0TWdyIFJhZElucHV0TWdyX0RlZmF1bHQgUmFkSW5wdXRfRXJyb3JfRGVmYXVsdB8iBTlSYWRJbnB1dE1nciBSYWRJbnB1dE1ncl9EZWZhdWx0IFJhZElucHV0X0Rpc2FibGVkX0RlZmF1bHQfIwU4UmFkSW5wdXRNZ3IgUmFkSW5wdXRNZ3JfRGVmYXVsdCBSYWRJbnB1dF9FbmFibGVkX0RlZmF1bHQWBmZmZmZmZmQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgkFDmN0bDAwJFJhZE1lbnUxBSBjdGwwMCRjb250ZW50Q2VudGVyJFJhZFRhYlN0cmlwMQUhY3RsMDAkY29udGVudENlbnRlciRSYWRNdWx0aVBhZ2UxBR5jdGwwMCRjb250ZW50Q2VudGVyJFJhZEJ1dHRvbjEFHmN0bDAwJGNvbnRlbnRDZW50ZXIkZWRUZ2xMYWhpcgUnY3RsMDAkY29udGVudENlbnRlciRlZFRnbExhaGlyJGNhbGVuZGFyBSdjdGwwMCRjb250ZW50Q2VudGVyJGVkVGdsTGFoaXIkY2FsZW5kYXIFHmN0bDAwJGNvbnRlbnRDZW50ZXIkUmFkQnV0dG9uMgUcY3RsMDAkY29udGVudENlbnRlciRncmlkUmVzMkAluj5zW+yhhAB+vtFr2iz+/SJto83482dTlVTv74KY',
            'ctl00$RadScriptManager1' => 'ctl00$ctl00$contentCenter$RadMultiPage1Panel|ctl00$contentCenter$RadButton1',
            'RadStyleSheetManager1_TSSM' => ';Telerik.Web.UI, Version=2019.1.115.40, Culture=neutral, PublicKeyToken=121fae78165ba3d4:en-US:756da6d1-591b-4d01-9a4a-d542d13dfc50:45085116:ed2942d4:c5d7b491:8cee9284:ed057d30:a3b7d93f:fe53831e:aac1aeb7:c73cf106:c86a4a06:4c651af2:9e1572d6:e25b4b77;Telerik.Web.UI.Skins, Version=2019.1.115.40, Culture=neutral, PublicKeyToken=121fae78165ba3d4:en-US:c113ea05-5009-4300-9124-ad7a3a2680ea:929e740d:f7a27b73',
            'RadScriptManager1_TSM' => ';;System.Web.Extensions, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35:en-US:50b12c66-1dd3-4ebf-87e6-55014086ad94:ea597d4b:b25378d2;Telerik.Web.UI:en-US:756da6d1-591b-4d01-9a4a-d542d13dfc50:16e4e7cd:f7645509:22a6274a:ed16cbdc:88144a7a:24ee1bba:33715776:e330518b:2003d0b8:c128760b:1e771326:c8618e41:1a73651d:333f8d94:8e6f0d33:1f3a7489:6a6d718d:6d43f6d9:7c926187:8674cba1:b7778d6c:c08e9f8a:a51ee93e:59462f1:58366029:e085fe68:82923ac3:1bb784d4',
            '__EVENTTARGET' => 'ctl00$contentCenter$RadButton1',
            '__EVENTARGUMENT' => '',
            '__VIEWSTATEGENERATOR' => '9ED6FB81',
            '__EVENTVALIDATION' => '/wEWDQK+s9a3DwK+6cGXBwKLrpzbAQLV7/muBQL4gLjaCwLV7/muBQLk6bWKBgK1geqEDwLV3siyDQKLrtTZAQLV7+2uBQL4gKzaCwLV7+2uBax2hdCtbGpx8T7dkLTkB8moVntt6EC6Cd6rhPdrHhjJ',
            'ctl00_RadMenu1_ClientState' => '',
            'ctl00_contentCenter_RadTabStrip1_ClientState' => '{\"selectedIndexes\":[\"0\"],\"logEntries\":[],\"scrollState\":{}}',
        ];
        $client = new Client(HttpClient::create(['verify_peer' => false]));
        $crawler = $client->request('GET', 'https://nisn.data.kemdikbud.go.id/page/data/');
        $form = $crawler->selectButton('Cari')->form();
        $crawler = $client->request($form->getMethod(), $form->getUri(), $values);
        $nisn = $crawler->filter('#contentCenter_lRes1NISN')->each(function ($node) {
            return $node->text();
        });
        return $value == $nisn[0];
    }
}
