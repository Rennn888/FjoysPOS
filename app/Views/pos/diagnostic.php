<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Diagnostic</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
            background: #1a1a1a;
            color: #00ff00;
        }
        .section {
            background: #2a2a2a;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #00ff00;
        }
        h2 {
            color: #00ff00;
            margin-top: 0;
        }
        .success {
            color: #00ff00;
        }
        .error {
            color: #ff0000;
        }
        .info {
            color: #ffff00;
        }
        pre {
            background: #1a1a1a;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
        button {
            background: #00ff00;
            color: #1a1a1a;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px;
        }
        button:hover {
            background: #00cc00;
        }
    </style>
</head>
<body>
    <h1>🔍 POS System Diagnostic</h1>
    
    <div class="section">
        <h2>Environment Info</h2>
        <div id="envInfo">Loading...</div>
    </div>

    <div class="section">
        <h2>API Configuration</h2>
        <div id="apiConfig">Loading...</div>
    </div>

    <div class="section">
        <h2>API Test</h2>
        <button onclick="testAPI()">Test API Connection</button>
        <button onclick="testAPIWithoutKey()">Test Without API Key</button>
        <div id="apiTest" style="margin-top: 10px;"></div>
    </div>

    <div class="section">
        <h2>Network Info</h2>
        <div id="networkInfo">Loading...</div>
    </div>

    <div class="section">
        <h2>Actions</h2>
        <button onclick="window.location.href='<?= base_url('pos') ?>'">Go to POS</button>
        <button onclick="location.reload()">Refresh Diagnostic</button>
    </div>

    <script>
        const API_BASE_URL = window.location.origin;
        const API_KEY = '<?= getenv('API_KEY') ?: 'Fjoy3211' ?>';

        // Display environment info
        document.getElementById('envInfo').innerHTML = `
            <pre>
User Agent: ${navigator.userAgent}
Platform: ${navigator.platform}
Language: ${navigator.language}
Online: ${navigator.onLine ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>'}
Screen: ${screen.width}x${screen.height}
Viewport: ${window.innerWidth}x${window.innerHeight}
            </pre>
        `;

        // Display API config
        document.getElementById('apiConfig').innerHTML = `
            <pre>
API Base URL: <span class="info">${API_BASE_URL}</span>
API Key: <span class="info">${API_KEY}</span>
Products Endpoint: <span class="info">${API_BASE_URL}/api/products</span>
CodeIgniter Base: <span class="info"><?= base_url() ?></span>
            </pre>
        `;

        // Display network info
        document.getElementById('networkInfo').innerHTML = `
            <pre>
Current URL: ${window.location.href}
Origin: ${window.location.origin}
Protocol: ${window.location.protocol}
Host: ${window.location.host}
Hostname: ${window.location.hostname}
Port: ${window.location.port}
Pathname: ${window.location.pathname}
            </pre>
        `;

        // Test API
        async function testAPI() {
            const output = document.getElementById('apiTest');
            output.innerHTML = '<span class="info">Testing API...</span>';
            
            try {
                const url = `${API_BASE_URL}/api/products`;
                console.log('Testing URL:', url);
                
                const response = await fetch(url, {
                    headers: { 'X-API-Key': API_KEY }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    output.innerHTML = `
                        <span class="success">✓ API Connection Successful!</span>
                        <pre>
Status: ${response.status}
Products Found: ${data.data ? data.data.length : 0}
Response:
${JSON.stringify(data, null, 2)}
                        </pre>
                    `;
                } else {
                    output.innerHTML = `
                        <span class="error">✗ API Error</span>
                        <pre>
Status: ${response.status}
Response:
${JSON.stringify(data, null, 2)}
                        </pre>
                    `;
                }
            } catch (error) {
                output.innerHTML = `
                    <span class="error">✗ Connection Failed</span>
                    <pre>
Error: ${error.message}
Stack: ${error.stack}
                    </pre>
                `;
            }
        }

        // Test API without key
        async function testAPIWithoutKey() {
            const output = document.getElementById('apiTest');
            output.innerHTML = '<span class="info">Testing API without key...</span>';
            
            try {
                const url = `${API_BASE_URL}/api/products`;
                const response = await fetch(url);
                const data = await response.json();
                
                output.innerHTML = `
                    <span class="info">Response without API key:</span>
                    <pre>
Status: ${response.status}
Response:
${JSON.stringify(data, null, 2)}
                    </pre>
                `;
            } catch (error) {
                output.innerHTML = `
                    <span class="error">✗ Connection Failed</span>
                    <pre>
Error: ${error.message}
                    </pre>
                `;
            }
        }

        // Auto-test on load
        window.addEventListener('load', () => {
            setTimeout(testAPI, 500);
        });
    </script>
</body>
</html>
