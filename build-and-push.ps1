# Build and Push Docker Image
# Usage: .\build-and-push.ps1 <your-dockerhub-username>

param(
    [Parameter(Mandatory=$true)]
    [string]$DockerUsername
)

$ImageName = "dork-search-generator"
$Tag = "latest"
$FullImage = "${DockerUsername}/${ImageName}:${Tag}"

Write-Host "Building Docker image..." -ForegroundColor Cyan
docker build -t $FullImage .

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Build successful!" -ForegroundColor Green
    Write-Host "`nPushing to Docker Hub..." -ForegroundColor Cyan
    Write-Host "Make sure you're logged in: docker login" -ForegroundColor Yellow
    
    docker push $FullImage
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Image pushed successfully!" -ForegroundColor Green
        Write-Host "`n📝 Update your docker-compose.yml:" -ForegroundColor Cyan
        Write-Host "Replace the build section with:" -ForegroundColor Yellow
        Write-Host "    image: $FullImage" -ForegroundColor White
    } else {
        Write-Host "❌ Push failed. Run 'docker login' first." -ForegroundColor Red
    }
} else {
    Write-Host "❌ Build failed" -ForegroundColor Red
}
